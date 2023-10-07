<?php
$host = 'localhost';
$db = 'srv56072_wish';
$user = 'srv56072_wish';
$pass = '1234';

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Błąd połączenia: " . $connection->connect_error);
}

// Ustawienie kodowania znaków na UTF-8
$connection->set_charset("utf8");
?>
