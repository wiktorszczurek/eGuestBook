<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['is_admin'] < 1) {
    header("location: login.php");
    die();
}

$admin_id = $_SESSION['admin_id'];
$is_main_admin = $_SESSION['is_admin'] == 2;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $is_admin = 0;
        
        // Sprawdzanie, który formularz został wysłany
        if (isset($_POST['create_admin']) && $_SESSION['is_admin'] == 2) {
            $is_admin = 1;
        }
        
        $password = bin2hex(random_bytes(3));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $server_id = bin2hex(random_bytes(10));

        $sql = "INSERT INTO users (username, password, is_admin, name, admin_id, server_start_time, server_id) VALUES ('$email', '$hashed_password', '$is_admin', '$name', '$admin_id', NULL, '$server_id')";

        
        if(mysqli_query($connection, $sql)){
            $to = $email;
            $subject = "Dane do logowania";
            $message = "Dziękujemy za wybór e-wishes.pl.\nO to twoje dane logowania do naszej aplikacji:\n\nLogin: $email\n\nHaslo: $password \n\nStrona logowania: https://e-wishes.pl/login.php ";
            $headers = 'From: ewishes.pl@gmail.com' . "\r\n" .
                'Reply-To: e-wishes.pl@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
        } else {
            echo "Błąd: " . $sql . "<br>" . mysqli_error($connection);
        }
    }

    if (isset($_POST['renew_server'])) {
        $user_id_to_renew = $_POST['user_id'];
        $currentTime = date("Y-m-d H:i:s");
        
        $stmt = mysqli_prepare($connection, "UPDATE users SET server_start_time = ?, server_active = 1 WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 'ss', $currentTime, $user_id_to_renew);
        
        if(mysqli_stmt_execute($stmt)) {
            echo "<p>Serwer dla użytkownika " . htmlspecialchars($user_id_to_renew) . " został przedłużony.</p>";
        } else {
            echo "<p>Wystąpił błąd przy przedłużaniu serwera dla użytkownika " . htmlspecialchars($user_id_to_renew) . ".</p>";
        }
        
        mysqli_stmt_close($stmt);
    }
    
    if (isset($_POST['delete_user'])) {
        $user_id_to_delete = $_POST['user_id'];
        $sql = "DELETE FROM users WHERE username = '$user_id_to_delete'";
        mysqli_query($connection, $sql);
        echo "<p>Uzytkownik {$user_id_to_delete} zostal usuniety.</p>";
    }
  
    if(isset($_GET['id'])) {
        $server_id = $_GET['id'];
        $qrLink = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode('http://e-wishes.pl/server.php?id=' . $server_id);

        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qr_code_' . $server_id . '.png"');
        
        echo file_get_contents($qrLink);
        exit;
}


}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
   body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
    }
    .container {
        width: 100%;
        max-width: 1200px;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0px 0px 10px 0px #0000001a;
    }
    a {
        color: #000;
        text-decoration: none;
    }
    form {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="email"] {
        width: 250px;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-dangerr {
        background-color: blue;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    button {
        display: block;
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    @media (max-width: 767px) {
        table, thead, tbody, th, td, tr {
            display: block;

        }
        table {
            margin-bottom: 7rem;

        }
        body {
            width: 90%;
        }
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr {
            margin-bottom: 7rem;
        }
        td {
            border: none;
            border-bottom: 1px solid #ddd;
            position: relative;
       
            text-align: center;
        }
        td:before {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            content: attr(data-column);
            color: #000;
            font-weight: bold;
        }
        input[type="text"],
    input[type="email"] {
        width: 80%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    }
    </style>
</head>
<body>
<div class="container">
<a href="logout.php">Wyloguj się</a>
<br>
<br>
<form action="" method="post">
    <label>Email:</label>
    <input type="email" name="email" required />
    <br>
    <label>Name:</label>
    <input type="text" name="name" required />
    <br>
    <button type="submit" value="Dodaj uzytkownika">Dodaj użytkownika</button>
</form>
<?php if ($_SESSION['is_admin'] == 2): ?>
    <form method="post">
        <label for="email">Email admina:</label>
        <input type="email" name="email" required>
        <br>
        
        <label for="name">Name admina:</label>
        <input type="text" name="name" required>
        <br>
        <input type="hidden" name="create_admin" value="1">
        <button type="submit" value="Utworz administratora">Dodaj admina</button>
    </form>
    <br>
    <br>
    
<?php endif; ?>



<?php
$currentTime = date('Y-m-d H:i:s');

$sql = $is_main_admin ? 
    "SELECT u.username, u.name, u.is_admin, u.server_start_time, u.server_id, a.name AS admin_name FROM users u LEFT JOIN users a ON u.admin_id = a.id ORDER BY u.is_admin DESC" : 
    "SELECT username, name, is_admin, server_start_time, server_id FROM users WHERE admin_id = '$admin_id' ORDER BY is_admin DESC";

$result = mysqli_query($connection, $sql);

echo "<table border='1'>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Pozostały czas (minuty)</th>
            <th>Akcje</th>";
            echo "<th>Link</th>";
            echo "<th>Pobierz kod QR</th>"; 

if($is_main_admin) {

    echo "<th>Dodany przez</th>";

}

echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $currentTime = new DateTime();
    $serverStartTime = new DateTime($row['server_start_time']);
    $interval = $currentTime->diff($serverStartTime);
    $totalSecondsPassed = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);
    
    $secondsLeft = 604800 - $totalSecondsPassed;

    $status = "Nie odpalony";
    if ($secondsLeft <= 0 && $row['server_start_time'] != null) {
        $status = "Serwer został zamknięty";
    } elseif ($row['server_start_time'] != null) {
        $days = floor($secondsLeft / (24*60*60));
        $hours = floor(($secondsLeft % (24*60*60)) / (60*60));
        $minutes = floor(($secondsLeft % (60*60)) / 60);
        $remainingSeconds = $secondsLeft % 60;
        $status = "<span class='timer'>" . $days . "d " . $hours . "h " . $minutes . "m " . $remainingSeconds . "s" . "</span>";
    }

    $rowColor = $row['is_admin'] ? 'style="background-color: rgb(227, 98, 98);"' : '';
    
    $server_id = $row['server_id'];

    echo "<tr $rowColor>
    <td>{$row['username']}</td>
    <td>{$row['name']}</td>
    <td>$status</td>
    <td>
        <form method='post' style='display:inline;'onsubmit='return confirm(\"Czy na pewno chcesz przedłużyc serwer: {$row['username']}?\");'>
            <input type='hidden' name='user_id' value='{$row['username']}'>
            <input type='submit' name='renew_server' class='btn-dangerr' value='Przedłuż'>
        </form>
        <form method='post' style='display:inline;' onsubmit='return confirm(\"Czy na pewno chcesz usunąć użytkownika {$row['username']}?\");'>
            <input type='hidden' name='user_id' value='{$row['username']}'>
            <input type='submit' name='delete_user' class='btn-danger' value='Usuń'>
        </form>
    </td>"; 
    echo "<td><a href='https://e-wishes.pl/view.php?id={$server_id}'>Serwer</a></td>";
    $qrDownloadLink = "download_qr.php?id=" . $server_id;
    echo "<td><a href='{$qrDownloadLink}'>Pobierz kod QR</a></td>";

    if ($is_main_admin) {
        echo "<td>{$row['admin_name']}</td>";

    }

    echo "</tr>";
}

echo "</table>";
?>


</div>
</body>
<script>
    function updateSeconds() {
        var timers = document.getElementsByClassName('timer');
        for (var i = 0; i < timers.length; i++) {
            var timer = timers[i];
            var timeArray = timer.textContent.split(' ');

            var days = parseInt(timeArray[0]);
            var hours = parseInt(timeArray[1]);
            var minutes = parseInt(timeArray[2]);
            var seconds = parseInt(timeArray[3]);

            seconds--;

            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                        days--;
                        if (days < 0) {
                            days = 0;
                            hours = 0;
                            minutes = 0;
                            seconds = 0;
                        }
                    }
                }
            }

            timer.textContent = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
        }
    }

    setInterval(updateSeconds, 1000);
</script>

</html>