<?php
include('config.php');

$server_id = $_GET['id'];

$sql = "SELECT username, server_start_time, name_of_server, name FROM users WHERE server_id = '$server_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$isServerActive = false;
$serverName = '';

if ($row) {
    $server_start_time = strtotime($row['server_start_time']);
    if ((time() - $server_start_time) < 604800) {
        $isServerActive = true;
        $serverName = !empty($row['name_of_server']) ? $row['name_of_server'] : "{$row['name']}";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>e-Wishes</title>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100;200;300&family=Parisienne&display=swap" rel="stylesheet">

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e0ebeb;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    h1 {
      color: #333;
        font-family: 'Cormorant Garamond', serif;
font-family: 'Josefin Sans', sans-serif;
font-family: 'Parisienne', cursive;
        font-weight: 300; /* Dodaj cienką czcionkę */
        margin-bottom: 3rem;
    }



    .btn {
    display: inline-block;
    width: 250px;        /* Adjust as needed */
    height: 65px;        /* Adjust as needed */
    line-height: 65px;   /* Vertically centers text */
    margin: 10px;
    background-color: #50b3a2;
    color: white;
    text-decoration: none;
    border-radius: 5px; /* Larger border radius for pill shape */
    transition: all 0.3s;
    text-align: center;     
    font-size: 1.1rem;

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
      footer {
    width: 100%;
    padding: 20px 0;
    position: absolute;
    bottom: 0;
    left: 0;
    
    text-align: center; /* centers the text horizontally */
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #333; /* dark gray text */
}
footer span{
    font-weight: bold;
}
h3{
color: #2C3E50;
    font-style: italic;
    font-weight: 300;
    margin-bottom: 20px;
    font-size: 2rem;
}
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
    <?php if ($isServerActive): ?>
        <h1><?php echo $serverName; ?></h1>
        <a href="add_photo.php?id=<?php echo $server_id; ?>" class="btn">Dodaj zdjęcie i życzenia</a>
        <a href="add_text.php?id=<?php echo $server_id; ?>" class="btn">Dodaj życzenia</a>
        <a href="view.php?id=<?php echo $server_id; ?>" class="btn">Księga Gości</a>
        <footer>
        <p style="margin-bottom: 10px;">
       
        <a
          href="https://itisws.pl"
          style="
            color: #50b3a2;;
            font-weight: medium;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-size: 1rem;
          "
          >Aplikacja stworzona przez <span>ITisws.pl</span></a
        >
      </p>
</footer>

    <?php elseif ($row): ?>
        <h3>Ten serwer został wyłączony.</h3>
    <?php else: ?>
        <h3>Serwer o podanym ID nie istnieje.</h3>
    <?php endif; ?>
</body>
</html>
