<?php
$host = 'localhost';
$db = '';
$user = '';
$pass = '';

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Błąd połączenia: " . $connection->connect_error);
}

// Ustawienie kodowania znaków na UTF-8
$connection->set_charset("utf8");
?>
