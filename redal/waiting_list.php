<?php
    require_once "init.php";
    
    function getRecentTickets() {
        global $conn, $unixTimeToday, $unixTimeTomorrow;
        $ticketsQuery = $conn->prepare('SELECT ticket_numero FROM tickets WHERE (date_time BETWEEN :dateToday AND :dateTomorrow) AND agence_id = :agence_id ORDER BY id DESC LIMIT 6');
        $ticketsQuery->execute(
            array(
                'dateToday' => $unixTimeToday,
                'dateTomorrow' => $unixTimeTomorrow,
                'agence_id' => 1
            )
        );

        $recentTickets = $ticketsQuery->fetchAll(PDO::FETCH_COLUMN);
        
        // Reverse the order of tickets
        $recentTickets = array_reverse($recentTickets);

        return $recentTickets;
    }

    $recentTickets = getRecentTickets();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recent Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f9f9;
        }

        .container {
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: red;
            margin-top: 0;
            margin-bottom: 10px;
            font-weight:bold;
            
        }

        .ticket-numbers {
        font-size: 18px;
        font-weight: bold;
        color: #555;
        margin-bottom: 0;
        display: inline;
        }

        .ticket-label {
            font-size: 18px;
            color: #555;
            margin-bottom: 0;
            display: inline;
            margin-left: 150px;
            font-weight: bold;
        }

        .ticket-list {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        .ticket-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .ticket-list li.served {
            color: #999;
        }

        .ticket-list li:first-child {
            background-color: #ffcccc;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .ticket-list li {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recent Tickets</h1>
        <p class="ticket-numbers">Ticket numbers</p><p class="ticket-label">Ticket Status</p>
        <ul class="ticket-list">
            <?php foreach ($recentTickets as $key => $ticketNumber) : ?>
                <li class="ticket-number <?php echo ($key === 0) ? 'served' : ''; ?><?php echo ($key === 0) ? ' first-ticket' : ''; ?>">
                    <span class="number"><?php echo $ticketNumber; ?></span>
                    <span class="state"><?php echo ($key === 0) ? 'en cours de traitement' : 'sera bientôt traité'; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
