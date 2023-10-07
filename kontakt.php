<?php
$messageSent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $content = $_POST["content"];
    $to = "wiktor.szczurek1@gmail.com";
    $subject = "Kontakt z eksiegi";
    $message = "e- ksiega. E-mail od: $email\n\nTreść wiadomości:\n$content";
    $headers = "From: $email";

    mail($to, $subject, $message, $headers);
    $messageSent = true;
}
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100;200;300&family=Parisienne&display=swap"
      rel="stylesheet"
    />
    <title>Formularz Kontaktowy</title>
    <style>
        form {
    width: 300px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px 0px #aaa;
    background-color: white;
    margin-top: 3rem;
    border-radius: 5px;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="email"] {
    width: 100%; 
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 5px;
}
textarea {
    width: 100%; 
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    resize: none; /* Blokuje możliwość zmiany rozmiaru */
    height: 150px; /* Możesz dostosować wysokość według potrzeb */
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    box-sizing: border-box;
}



button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #50b3a2;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;;
}

button:hover {
    background-color: #17a589;
}
p{
    text-align: center;
}

body {
        font-family: "Arial", sans-serif;
        background-color: #e0ebeb;
        margin: 0;
        padding: 0;
        line-height: 1.6;
        width: 100vw;
        height: 100vh;
        min-height: 100vh;
        flex-direction: column;
        position: relative;
        left: 0;
        display: flex;
      }
      header {
        background: #50b3a2;
        color: #ffffff;
        padding: 10px;
        text-align: center;
      }
      nav {
        text-align: center;
        margin-top: 20px;
      }
      ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: inline-block; /* aby elementy menu były w jednej linii */
      }
      li {
        display: inline;
        margin-right: 20px; /* dodajemy odstęp między elementami menu */
      }
      a {
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
      }
      a:hover {
        text-decoration: underline;
      }
      h1 {
        color: #ffffff;
        font-family: "Cormorant Garamond", serif;
        font-family: "Josefin Sans", sans-serif;
        font-family: "Parisienne", cursive;
        font-weight: 300; /* Dodaj cienką czcionkę */
      }
      h1,
      h2 {
        font-size: 2rem;
      }
#menu-button {
        display: none;
        cursor: pointer;
        font-size: 2rem;
        background: none;
        border: none;
        color: white;
      }

      #navbar {
        transition: max-height 0.5s ease-in-out;
        max-height: 200px; /* Dostosuj tę wartość zgodnie z rzeczywistą maksymalną wysokością menu */
        overflow: hidden;
      }
      li a {
        color: white;
        text-decoration: none !important;
        font-size: 1.2rem;
        position: relative;
        overflow: hidden;
        padding-bottom: 5px;
      }

      li a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 1.6px;
        bottom: 0;
        left: 0;
        background-color: white;
        transition: width 0.3s ease-in-out;
      }

      li a:hover::after {
        width: 100%;
      }
     
@media screen and (max-width: 762px) {
        header {
          padding: 5px;
        }
        header h1 {
          font-size: 1.5rem;
        }
        #menu-button {
          font-size: 1.5rem;
        }
        #menu-button {
          display: block;
        }
        #navbar {
          max-height: 0; /* Ukryj menu dla mobilnych */
          padding-top: 0;
        }
        #navbar.active {
          max-height: 200px; /* Pokaż menu (dostosuj wartość) */
        }
        #navbar ul li {
          display: block; /* Elementy menu jeden pod drugim */
          margin-right: 0;
          padding: 8px;
          text-align: center;
        }
        header {
          padding: 5px;
        }
        header h1 {
          font-size: 2rem;
          margin-bottom: 0; /* Zmniejsz margines u dołu nagłówka */
        }
        #menu-button {
          font-size: 1.5rem;
          margin-top: 0; /* Zmniejsz margines u góry przycisku */
          margin-bottom: 0;
        }
        nav {
          margin-top: 0; /* Zmniejsz margines górny dla elementu nav */
        }
      }
      .footer {
        margin-top: auto;
        left: 0;
        width: 100%;
        background-color: #50b3a2;
        color: white;
        text-align: center;
        padding: 10px 0;
      }
      .footer span {
        font-weight: bold;
      }
      p {
    margin-top: 0; /* Usunięcie marginesu górnego */
    margin-bottom: 0.3em; /* Zmniejszenie marginesu dolnego */
}

    </style>
</head>
<body>
<header>
<h1><a class="kupa" href="index.html" style="color: #ffffff; text-decoration: none; font-size:2rem;">e-Wishes</a></h1>

      <button id="menu-button"><i class="bi bi-list"></i></button>
      <nav id="navbar">
        <ul>
          <li><a href="login.php">Zaloguj się</a></li>

          <li><a href="dostep.php">Uzyskaj dostęp</a></li>
          <li><a href="kontakt.php">Kontakt</a></li>
          
        </ul>
      </nav>
    </header>
    <br>
    <br>
    <?php if ($messageSent): ?>
            <p>Wiadomość została wysłana!</p>
            <p>Napiszemy do Ciebie tak szybko, jak to możliwe!</p>
        <?php else: ?>
            <p>Masz jakieś pytania, lub masz problem z aplikacją?</p>
            <p>Skontaktuj się z nami a my postaramy się rozwiązać Twój problem.</p>
            <form action="kontakt.php" method="post">
                <label for="email">Podaj swój e-mail:</label>
                <input type="email" id="email" name="email" required>
                <label for="content">Treść wiadomości:</label>
                <textarea id="content" name="content" required></textarea>
                <button type="submit">Wyślij</button>
            </form>
        <?php endif; ?>
        <br>
        <br>

        <footer class="footer">
      <p style="margin-bottom: 10px; font-size: 1rem; color: white">
        &copy; 2023. Wszystkie prawa zastrzeżone.<br />
        <a
          href="https://itisws.pl"
          style="
            color: white;
            font-weight: medium;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-size: 1rem;
          "
          >Created by <span>ITisws.pl</span></a
        >
      </p>
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
      var menuButton = document.getElementById("menu-button");
      var navbar = document.getElementById("navbar");

      menuButton.addEventListener("click", function () {
        navbar.classList.toggle("active");
      });
    });
  </script>
</html>
