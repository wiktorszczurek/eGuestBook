<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukces</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100;200;300&family=Parisienne&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMt23CEz/5paNdF+TmFEQ5Bm5O5TV5mpMvqGdQCE" crossorigin="anonymous">

    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #e0ebeb;
    font-family: 'Arial', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
   
    margin: 0;
}

form {
    background-color: #e0ebeb;
    padding: 30px;
    border-radius: 10px;
    
    max-width: 350px;
    text-align: center;
}

label {
    display: block;
    margin-bottom: 10px;
    font-size: 14px;
    color: #333333;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #50b3a2;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}


a {
    text-decoration: none;
    color: black;
}
h2 {
        color: black;
        font-family: "Cormorant Garamond", serif;
        font-family: "Josefin Sans", sans-serif;
        font-family: "Parisienne", cursive;
        font-weight: 300; /* Dodaj cienką czcionkę */
        text-align: center;
        margin-bottom: 30px;
      }
      h2 a {
        text-decoration:none;
        color: black;
      }
</style>
</head>
<body>
<form action="" method="post">
<h2>
        <a
          class="kupa"
          href="index.html"
          style=" text-decoration: none; font-size: 2rem"
          >e-Wishes.pl</a
        >
      </h2>
<div style="text-align: center; padding: 20px;">
    <?php 
    if(!empty($_SESSION['message'])): 
        echo '<div style="color: green; margin-bottom: 15px;">';
        echo htmlspecialchars($_SESSION['message']);
        echo '</div>';
        unset($_SESSION['message']); // usuń wiadomość po wyświetleniu
    endif; 

    if(!empty($_SESSION['error'])): 
        echo '<div style="color: red;  margin-top: 15px;">';
        echo htmlspecialchars($_SESSION['error']);
        echo '</div>';
        unset($_SESSION['error']); // usuń błąd po wyświetleniu
    endif;
    ?>

    <a href="index.html">Powrót do strony głównej</a>
</div>
</form>
</body>
</html>
