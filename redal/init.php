<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
define('APP_NAME', 'Ticket System');

$Configs = array();

$Configs['MySQL'] = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'gestion_tickets',
);

// $conn = new PDO('mysql:host=localhost;dbname=gestion_tickets;', 'root', '', array(
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
// ));

try {
    $conn = new PDO('mysql:host='.$Configs['MySQL']['host'].';dbname='.$Configs['MySQL']['dbname'].';', $Configs['MySQL']['username'], $Configs['MySQL']['password'], array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (\Throwable $th) {
    //throw $th;
    echo 'Probleme De Connexion MySQL '. $th->getMessage();
    exit;
}

require_once('./functions.php');

?>