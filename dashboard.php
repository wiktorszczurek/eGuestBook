<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    die();
}

$user_id = $_SESSION['login_user'];
$server_id = null;
$server_start_time = null;
$admin_email = null;


$sql = "SELECT u.server_id, u.server_start_time, u.server_active, a.username as admin_email FROM users u LEFT JOIN users a ON u.admin_id = a.id WHERE u.username = '$user_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$server_active = $row['server_active'];


if ($row['server_id']) {
    $server_id = $row['server_id'];
    $server_start_time = strtotime($row['server_start_time']);
    $admin_email = $row['admin_email'];
}

if (isset($_POST['create_server'])) {
    if (!$row['server_start_time']) {
        $sql = "UPDATE users SET server_start_time = NOW(), server_active = 1 WHERE username = '$user_id'";
        mysqli_query($connection, $sql);
        $server_start_time = time();

        // Przekierowuje na dashboard.php po przetworzeniu danych
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Już uruchomiłeś księgę gości.";
    }

    } elseif (isset($_POST['send_message'])) {
        $message = mysqli_real_escape_string($connection, $_POST['message']);
        $to = $admin_email; // teraz wiadomość jest wysyłana do admina
        $subject = "Wiadomość od użytkownika $user_id";
        $headers = 'From: ' . $user_id . "\r\n" .
            'Reply-To: ' . $user_id . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        if ($to) {
            mail($to, $subject, $message, $headers);
            echo "<p>Wiadomość została wysłana!</p>";
        } else {
            echo "<p>Błąd: Nie można wysłać wiadomości, brak adresu e-mail admina.</p>";
        }
    }
        if (isset($_POST['update_server_name'])) {
            $name_of_server = mysqli_real_escape_string($connection, $_POST['name_of_server']);
            $sql = "UPDATE users SET name_of_server = '$name_of_server' WHERE username = '$user_id'";
            mysqli_query($connection, $sql);
            echo "<p>Nazwa serwera została zaktualizowana!</p>";
        }
        if ($server_start_time && (time() - $server_start_time) >= 604800) {
 
            $sql = "UPDATE users SET server_active = 0 WHERE username = '$user_id'";
            mysqli_query($connection, $sql);
            $is_server_active = false;
        }
        


$sql = "SELECT name_of_server, name FROM users WHERE username = '$user_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$serverName = '';
if ($row) {
    $serverName = $row['name_of_server'] ? $row['name_of_server'] : "{$row['name']}";
}


$is_server_active = ($server_id && $server_active && (time() - $server_start_time) < 604800);


$remaining_time = 604800 - (time() - $server_start_time); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <style>
        body{
            text-align: center;
            background-color: #e0ebeb;
            font-family: 'Arial', sans-serif;
        }
        input[type="submit"][name="create_server"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #50b3a2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .button-download {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.download-link {
    text-decoration: none;
    display: inline-block;
}
.update-button {
    padding: 5px 10px;
    background-color: #50b3a2;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 14px;
    border-radius: 5px;
}


    </style>
    
</head>
<body>



<?php if ($is_server_active): ?>
    <p>Twój serwer jest aktywny!</p>
    <p>Link do serwera: <a href="http://e-wishes.pl/server.php?id=<?php echo $server_id; ?>">http://e-wishes.pl/server.php?id=<?php echo $server_id; ?></a></p>
    
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode('http://e-wishes.pl/server.php?id=' . $server_id); ?>" alt="QR Code">
    <br>
    <a href="download_qr.php?id=<?php echo $server_id; ?>" class="download-link">
        <button type="button" class="button-download">Pobierz kod QR</button>
    </a>








    <?php 
    
    $remaining_seconds = 604800 - (time() - $server_start_time);
    $days = floor($remaining_seconds / (24*60*60));
    $hours = floor(($remaining_seconds % (24*60*60)) / (60*60));
    $minutes = floor(($remaining_seconds % (60*60)) / 60);
    $seconds = $remaining_seconds % 60;
    ?>
    <p id="remainingTime">Pozostało czasu: <?php echo "{$days} dni, {$hours} godzin, {$minutes} minut, {$seconds} sekund"; ?></p>
   
    <?php if ($server_id): ?>
        <form action="" method="post">
            <label>Nazwa księgi:</label>
            <input type="text" name="name_of_server" required>
            <input type="submit" name="update_server_name" value="Zaktualizuj" class="update-button">

        </form>
        <p>Aktualna nazwa księgi: <strong><?php echo htmlspecialchars($serverName); ?></strong></p>
        
        <a href="view.php?id=<?php echo $server_id; ?>" class="btn">Księga Gości</a>
        <br>
        <a href="download.php?id=<?php echo $server_id; ?>" class="btn">Pobierz wszystkie zdjęcia</a>
        
        
<?php endif; ?>
<?php elseif ($server_id && $server_start_time): ?>
    <p>Twój serwer został wyłączony.</p>
    <p>Możesz dalej zobaczyć swoją księge gości!</p>
    <a href="view.php?id=<?php echo $server_id; ?>" class="btn">Księga Gości</a>
    <a href="download.php?id=<?php echo $server_id; ?>" class="btn">Pobierz wszystkie zdjęcia</a>
    <br>
    <form action="" method="post">
        <p>Chcesz przedłużyć aplikację? Napisz do nas i podaj powód.</p>
        <label>Twoja wiadomość:</label>
        <textarea name="message" required></textarea>
        <input type="submit" name="send_message" value="Wyślij">
    </form>
    <?php elseif ($server_id && !$server_start_time): ?>
    <form action="" method="post">
    <p>Klikając poniższy przycisk, włączysz aplikację Księga Gości, która będzie dostępna przez 7 dni.</p>
    <input type="submit" name="create_server" value="Włącz Księgę Gości!" onclick="return confirm('Czy na pewno chcesz włączyć aplikację Księga Gości?');">


    </form>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
<?php endif; ?>




    
</body>
<script>
function updateRemainingTime() {
    var timeElement = document.getElementById('remainingTime');
    if (timeElement) {
        var timeText = timeElement.textContent || timeElement.innerText;
        var regex = /(\d+) dni, (\d+) godzin, (\d+) minut, (\d+) sekund/;
        var matches = timeText.match(regex);
        if (matches) {
            var days = parseInt(matches[1]);
            var hours = parseInt(matches[2]);
            var minutes = parseInt(matches[3]);
            var seconds = parseInt(matches[4]);

            // aktualizacja czasu
            if (seconds > 0) {
                seconds--;
            } else if (minutes > 0) {
                minutes--;
                seconds = 59;
            } else if (hours > 0) {
                hours--;
                minutes = 59;
                seconds = 59;
            } else if (days > 0) {
                days--;
                hours = 23;
                minutes = 59;
                seconds = 59;
            }

            timeElement.textContent = 'Pozostało czasu: ' + days + ' dni, ' + hours + ' godzin, ' + minutes + ' minut, ' + seconds + ' sekund';
        }
    }
}

setInterval(updateRemainingTime, 1000);

</script>
</html>
