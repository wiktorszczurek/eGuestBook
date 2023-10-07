<?php
include('config.php');
session_start();

$server_id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note = mysqli_real_escape_string($connection, $_POST['note']);
    $signature = mysqli_real_escape_string($connection, $_POST['signature']);
    
    $sql = "INSERT INTO server_content (server_id, note, signature) VALUES ('$server_id', '$note', '$signature')";
    if (mysqli_query($connection, $sql)) {
        // Przekieruj użytkownika do strony view.php z odpowiednim ID serwera
        header("Location: view.php?id=" . $server_id, true, 303);
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

$sql = "SELECT username, server_start_time, name_of_server FROM users WHERE server_id = '$server_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$isServerActive = false;
$serverName = '';

if ($row) {
    $server_start_time = strtotime($row['server_start_time']);
    if ((time() - $server_start_time) < 604800) {
        $isServerActive = true;
        $serverName = !empty($row['name_of_server']) ? $row['name_of_server'] : "Witaj na serwerze użytkownika {$row['username']}!";
    }
}
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dodaj życzenia</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100;200;300&family=Parisienne&display=swap" rel="stylesheet">

        <style>
         body {
    font-family:  'Arial', sans-serif;
    background-color: #e0ebeb;
    margin: 0;
    padding: 0;
    text-align: center;
}

h1 {
    color: #2C3E50;
    font-style: italic;
    font-weight: 300;
    margin-bottom: 20px;
}

.container {
    width: 30%;
    margin: auto;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 15px 5px rgba(0, 0, 0, 0.04);
}

label {
    font-size: 18px;
    color: #333;
    margin-top: 10px;
    display: block;
}

input[type="file"],
input[type="text"],
textarea,
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    font-size:1rem;
}

input[type="submit"] {
    display: block;
    background-color: #50b3a2;
    border: none;
    color: #fff;
    cursor: pointer;
    margin-top: 10px;
}


.btn {
    display: inline-block;
    width: 150px;        /* Adjust as needed */
    height: 45px;        /* Adjust as needed */
    line-height: 45px;   /* Vertically centers text */
    margin: 10px;
    background-color: #50b3a2;
    color: white;
    text-decoration: none;
    border-radius: 5px; /* Larger border radius for pill shape */
    transition: all 0.3s;
    text-align: center; 

    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.btn:hover {
    background-color: #3c8d81; /* Darker shade on hover */
    transform: translateY(-3px); /* Moves up slightly on hover */
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15); /* Increased shadow on hover */
}

.btn:active {
    transform: translateY(-1px); /* Moves down slightly when pressed */
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12); /* Reduced shadow when pressed */
}


.message {
    margin: 20px 0;
    padding: 10px;
    border-radius: 5px;
    color: #333;
}

.success {
    background: #dff0d8;
}

.error {
    background: #f2dede;
}
@media screen and (max-width: 762px) {
    .container {
    width: 90%;
    margin: auto;
}
}
.file-upload {
        position: relative;
        overflow: hidden;
        margin: 10px;
        
    }
    .file-upload input[type='file'] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
        margin-bottom: 10px;
    }
    .file-upload label {
        padding: 10px;
        color: #fff;
        background-color: #5cb85c;
        border-radius: 5px;
        cursor: pointer;
    }
    .file-name {
        margin-top: 10px;
        font-size: 16px;
        
    }
    h2 {
        color: black;
        font-family: "Cormorant Garamond", serif;
        font-family: "Josefin Sans", sans-serif;
        font-family: "Parisienne", cursive;
        font-weight: 300; /* Dodaj cienką czcionkę */
        text-align: center;
      }
      h2 a {
        text-decoration:none;
        color: black;
      }

    </style>

        </style>
    </head>
    <body>
    <h2>
        <a
          class="kupa"
          href="index.html"
          style=" text-decoration: none; font-size: 2rem"
          >e-Wishes.pl</a
        >
      </h2>
    <div class="container">
    <?php if ($isServerActive): ?>
        <a href="view.php?id=<?php echo $server_id; ?>" class="btn">Księga Gości</a>
        <a href="server.php?id=<?php echo $server_id; ?>" class="btn" id="menu-btn">Menu</a>
<form action="" method="post">
    <label>Życzenia:</label>
    <textarea name="note" required></textarea>
    <label>Podpis:</label>
    <input type="text" name="signature" required>
    <input type="submit" value="Dodaj" name="submit">
</form>
<?php elseif ($row): ?>
        <h1>Ten serwer został wyłączony.</h1>
    <?php else: ?>
        <h1>Serwer o podanym ID nie istnieje.</h1>
    <?php endif; ?>
    </div>
    </body>
    </html>