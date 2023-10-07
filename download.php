<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    die();
}

$server_id = $_GET['id'];
$zip = new ZipArchive();
$filename = "/tmp/$server_id.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("Nie można otworzyć <$filename>\n");
}

$sql = "SELECT image_path FROM server_content WHERE server_id = '$server_id'";
$result = mysqli_query($connection, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $zip->addFile($row['image_path']);
}

$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$filename);
header('Content-Length: ' . filesize($filename));
readfile($filename);

unlink($filename);
?>
