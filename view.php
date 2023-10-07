<?php
include('config.php');
$server_id = $_GET['id'];


$sql = "SELECT * FROM server_content WHERE server_id = '$server_id'";
$result = mysqli_query($connection, $sql);


$sql_server_name = "SELECT name FROM users WHERE server_id = '$server_id'";
$result_server_name = mysqli_query($connection, $sql_server_name);
$row_server_name = mysqli_fetch_assoc($result_server_name);
$serverName = $row_server_name['name'];
?>
<?php
$sql_server_name = "SELECT name_of_server, name FROM users WHERE server_id = '$server_id'";
$result_server_name = mysqli_query($connection, $sql_server_name);
$row_server_name = mysqli_fetch_assoc($result_server_name);

$serverName = !empty($row_server_name['name_of_server']) ? $row_server_name['name_of_server'] : $row_server_name['name'];
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Księga Gości</title>
    <link rel="stylesheet" href="styles.css"> <!-- Dodaj plik CSS -->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100;200;300&family=Parisienne&display=swap" rel="stylesheet">

    <style>
body {
    background-color: #e0ebeb;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;
    margin-bottom:20rem;
}

#content-to-pdf {
    padding: 20px;
}



.postcard {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    margin: 20px auto;
    max-width: 300px;
    overflow: hidden;
    padding: 20px;
    transition: transform 0.5s, box-shadow 0.5s;
    transform: rotate(4deg);
    margin-bottom: 5rem;
}
@media screen and (max-width: 762px) {
    .postcard {
        max-width: 60%;
    }
}

.postcard.left {
    transform: rotate(-4deg);
}

.postcard:hover {
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.2);
}

.postcard.clicked {
    transform: rotate(0deg);
}

.postcard img {
    border-radius: 5px;
    margin-bottom: 15px;
    max-width: 100%;
}

.postcard p {
    color: #2c3e50;
    font-size: 16px;
    line-height: 1.6;
}
.signature {
    font-style: italic;
    margin-top: 10px;
    font-size: 142px;
    color:black;
}
.postcard {
    page-break-inside: avoid; /* Unikaj łamania stron wewnątrz pocztówki */
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



        #extra-background {
    background-color: #e0ebeb; /* Ustaw ten kolor na kolor tła strony */
    height: 100px; /* Ustaw wysokość według potrzeb */
}
        h1 {
        color: #333;
        font-family: 'Cormorant Garamond', serif;
font-family: 'Josefin Sans', sans-serif;
font-family: 'Parisienne', cursive;
        font-weight: 300; /* Dodaj cienką czcionkę */
        margin-bottom: 3rem;
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

a {
    cursor: pointer;
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

<br>

<a  class="btn" id="download-pdf">Pobierz PDF</a>
<a href="server.php?id=<?php echo $server_id; ?>" class="btn" id="menu-btn">Menu</a>

<a href="add_photo.php?id=<?php echo $server_id; ?>" class="btn" id="add-photo-btn">Dodaj zdjęcie</a>
<a href="add_text.php?id=<?php echo $server_id; ?>" class="btn" id="add-text-btn">Dodaj życzenia</a>



<h1><?php echo $serverName; ?></h1>
    <?php
    $rotateRight = true;
    while ($row = mysqli_fetch_assoc($result)):
    ?>
        <div class="postcard <?php echo $rotateRight ? '' : 'left'; ?>">
            <?php if (!empty($row['image_path'])): ?>
                <img src="<?php echo $row['image_path']; ?>" alt="Image">
            <?php endif; ?>
            <p><?php echo htmlspecialchars($row['note']); ?></p>
            <p class="signature" style="font-size: 1.1rem;" style="color: black;"><?php echo htmlspecialchars($row['signature']); ?></p>
        </div>
        <?php
        $rotateRight = !$rotateRight;
    endwhile;
    ?>

<div id="extra-background"></div>

<script>



    $('.postcard').click(function() {
        $(this).toggleClass('clicked');
    });
</script>
<script>
    document.getElementById('download-pdf').addEventListener('click', () => {
 
        document.getElementById('download-pdf').style.display = 'none';
        document.getElementById('menu-btn').style.display = 'none';
        document.getElementById('add-photo-btn').style.display = 'none';
        document.getElementById('add-text-btn').style.display = 'none';
        
        var element = document.body; 
        
    
        var opt = {
            margin: 10,
            filename: 'e-ksiega.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 1, useCORS: true, letterRendering: true, allowTaint: true },

            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
      
        html2pdf().from(element).set(opt).save().then(function () {
           
            document.getElementById('download-pdf').style.display = 'inline-block';
            document.getElementById('menu-btn').style.display = 'inline-block';
            document.getElementById('add-photo-btn').style.display = 'inline-block';
            document.getElementById('add-text-btn').style.display = 'inline-block';
        });
    });
</script>



</body>
</html>
