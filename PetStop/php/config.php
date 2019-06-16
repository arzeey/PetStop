<?php 

// Define key variables for connection
// $db_host = 'localhost';
// $db_user = 's2991625';
// $db_pass = 'rcusserv';
// $db_name = 's2991625';

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'petstop';

// Establish a new connection using PDO
try {
    $conn = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    return $e->getMessage();
}

?>