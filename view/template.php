<?php

$titre = (isset($titre)) ? $titre : "";
$titre_secondaire = (isset($titre_secondaire)) ? $titre_secondaire : "";

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
    <div class="overlay2"></div>
    <div class="OverlayModalConfirmation"></div>

    <header>
        <!-- NAVBAR -->
        <nav id="navbar">
            <ul>
                <img src="public/img/logo.jpg" alt="logo CNEMA Cretria">
                <li><a href="index.php?action=accueil">Accueil</a></li>
                <li><a href="index.php?action=listFilms">Tous les films</a></li>
                <?php
                if (isset($_SESSION['user']) && $_SESSION['admin'] == 0) {
                ?>
                    <!-- <li><a href="index.php?action=profil">Profil</a></li> -->
                    <li><a href="index.php?action=logout">Déconnexion</a></li>
                <?php
                } elseif (isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
                ?>
                    <li><a href="index.php?action=admin">Admin</a></li>
                    <!-- <li><a href="index.php?action=profil">Profil</a></li> -->
                    <li><a href="index.php?action=logout">Déconnexion</a></li>
                <?php
                } else { 
                ?>
                    <li><a href="index.php?action=login">Connexion</a></li>
                    <li><a href="index.php?action=register">Inscription</a></li>
                <?php
                }
                ?>
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

<?php 
if(isset($_SESSION['message'])) { 
    ?>
    <div id="alert"><?= $_SESSION['message'] ?></div>
    <script>tempAlert(3000, 'alert')</script>
    <?php
    unset($_SESSION['message']);
}

if(isset($_SESSION['messageError'])) { 
    ?>
    <div id="alertError"><?= $_SESSION['messageError'] ?></div>
    <script>tempAlert(3000, 'alertError')</script>
    <?php
    unset($_SESSION['messageError']);
}
?>

</body>

</html>