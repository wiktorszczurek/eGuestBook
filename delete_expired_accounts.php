<?php
include('config.php');

$expiration_time = 5 * 60; // 5 minut

$sql = "SELECT id, TIMESTAMPDIFF(SECOND, server_start_time, NOW()) as elapsed_time FROM users WHERE server_start_time IS NOT NULL";
$result = mysqli_query($connection, $sql);

while($row = mysqli_fetch_assoc($result)) {
    if ($row['elapsed_time'] > $expiration_time) {
        $userId = $row['id'];
        $sql = "DELETE FROM users WHERE id = '$userId'";
        mysqli_query($connection, $sql);
    }
}
?>
