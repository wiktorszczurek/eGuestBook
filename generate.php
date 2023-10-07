<?php
$haslo = "kupa"; // Tutaj wpisz wybrane hasło administratora.
$haslo_zahashowane = password_hash($haslo, PASSWORD_DEFAULT);
echo $haslo_zahashowane;
?>
