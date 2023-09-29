<?php
    $unixTimeToday = strtotime('today');
    $unixTimeTomorrow = strtotime('tomorrow');

    function lastTicketToday(){
        global $conn, $unixTimeToday, $unixTimeTomorrow;
        $ticketsQuery = $conn->prepare('SELECT * FROM tickets WHERE ( date_time BETWEEN :dateToday AND :dateTomorrow ) AND agence_id = :agence_id ORDER BY date_time DESC LIMIT 1');
        $ticketsQuery->execute(
            array(
                'dateToday' => $unixTimeToday,
                'dateTomorrow' => $unixTimeTomorrow,
                'agence_id' => 1
            )
        );
        $lastTicket = $ticketsQuery->fetch();
        return $lastTicket;
    }

    function createTicket(){
        global $conn;
        $lastTicket = lastTicketToday();
        if($lastTicket === false){
            $lastTicket = array('ticket_numero' => 0);
        }
        $ticketQuery = $conn->prepare('INSERT INTO tickets (ticket_numero, date_time, agence_id, language) VALUES (:ticket_numero, :date_time, :agence_id, :language)');
        $ticketQuery->execute(array(
            'ticket_numero' => $lastTicket['ticket_numero'] + 1,
            'date_time' => strtotime('now'),
            'agence_id' => 1,
            'language' => 'en-EN'
        ));
        return $conn->lastInsertId();
    }

    function getTicketInfos( $ticket_id ){
        global $conn;
        $ticketInfosQuery = $conn->prepare('SELECT * FROM tickets WHERE id = :id');
        $ticketInfosQuery->execute(array('id' => intval($ticket_id)));
        $ticket = $ticketInfosQuery->fetch();
        return $ticket;
    }

    function getTicketsList(){
        global $conn, $unixTimeToday, $unixTimeTomorrow;
        $ticketsQuery = $conn->prepare('SELECT * FROM tickets WHERE ( date_time BETWEEN :dateToday AND :dateTomorrow ) AND agence_id = :agence_id ORDER BY id DESC LIMIT 5');
        $ticketsQuery->execute(
            array(
                'dateToday' => $unixTimeToday,
                'dateTomorrow' => $unixTimeTomorrow,
                'agence_id' => 1
            )
        );
        $ticketsCount = $ticketsQuery->rowCount();
        $ticketsList = $ticketsQuery->fetchAll();
        return array('count'=> $ticketsCount, 'results' => $ticketsList);
    }

    function getAllTicketsList(){
        global $conn;
        $ticketsQuery = $conn->prepare('SELECT * FROM tickets WHERE agence_id = :agence_id ORDER BY id DESC');
        $ticketsQuery->execute(
            array(
                'agence_id' => 1
            )
        );
        $ticketsCount = $ticketsQuery->rowCount();
        $ticketsList = $ticketsQuery->fetchAll();
        return array('count'=> $ticketsCount, 'results' => $ticketsList);
    }
    $user_ip = "192.168.1.30";
$sql = "SELECT localisation FROM agence WHERE ip_address = :ip_address";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':ip_address' => $user_ip));
$result = $stmt->fetch();

if ($result) {
    $localisation = $result["localisation"];
} else {
    $localisation = "Unknown";
}

?>