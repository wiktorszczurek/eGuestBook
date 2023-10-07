<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($connection, $_POST['username']);
    
    $sql = "SELECT id, username FROM users WHERE username = '$email'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    if ($row) {
        $token = bin2hex(random_bytes(50));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password_reset_token='$hashedToken' WHERE username='$email'";
        $result = mysqli_query($connection, $sql);
        
        if ($result) {
            $resetLink = "http://e-wishes.pl/reset_password.php?token=$token&email=$email";
            $message = "Kliknij poniższy link, aby zresetować hasło: $resetLink";
            $headers = "From: no-reply@e-wishes.pl\r\n";
            mail($email, "Resetowanie hasła", $message, $headers);
            $_SESSION['message'] = "Link do resetowania hasła został wysłany na Twój adres e-mail.";
            header('Location: success.php');
            exit;
        } else {
            $error = "Wystąpił błąd podczas resetowania hasła.";
           
        }
    } else {
        $error = "Nie znaleziono użytkownika o podanym adresie e-mail.";
        
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przypomnij Hasło</title>
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
    height: 100vh;
    margin: 0;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
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
    <?php if(!empty($message)): ?>
    <div style="color: green; margin-bottom: 15px; text-align: center;">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>
        
        <input type="email" name="username" required placeholder="E-mail" />
        <input type="submit" name="reset" value="Przypomnij hasło"></input>
        <?php if(!empty($error)): ?>
    <div style="color: red;  margin-top: 15px; text-align:center;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
    </form>
</body>
</html>
