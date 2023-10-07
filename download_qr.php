<?php
if(isset($_GET['id'])) {
    $server_id = $_GET['id'];
    $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode('http://e-wishes.pl/server.php?id=' . $server_id);

    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="QRCode_' . $server_id . '.png"');

    echo file_get_contents($qr_url);
}
