<?php

$titre = (isset($titre)) ? $titre : "";
$titre_secondaire = (isset($titre_secondaire)) ? $titre_secondaire : "";

if(isset($_SESSION['Message'])) {
    echo $_SESSION['Message'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Script fontawesome -->
    <script src="https://kit.fontawesome.com/de7e6c09fa.js" crossorigin="anonymous"></script>
    <!-- Link CSS -->
    <link rel="stylesheet" href="public/css/style.css">

    <title><?= $titre ?></title>
</head>

<body>
    <div class="overlay"></div>

    <header>
        <!-- NAVBAR -->
        <nav id="navbar">
            <ul>
                <img src="public/img/logo.jpg" alt="logo CNEMA Cretria">
                <li><a href="index.php?action=accueil">Accueil</a></li>
                <li><a href="index.php?action=admin">Admin</a></li>
            </ul>
        </nav>
    </header>

    <?= $contenu ?>

    <!-- FOOTER -->
    <footer id="footer">
        <div class="whiteline"></div>
        <div class="footer-social">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>

        <div class="bot">
            <p>&copy; Copyright 2023 CNEMA Cretria</p>
            <img src="public/img/logo.jpg" alt="logo CNEMA Cretria">
        </div>
    </footer>

    <!-- script -->
    <script type="text/javascript" src="public/js/script.js"></script>
</body>

</html>