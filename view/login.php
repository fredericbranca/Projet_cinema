<?php

if (isset($_SESSION['user'])) {
    $_SESSION['messageError'] = "Vous êtes déjà connecté";
    header("Location: index.php?action=accueil");
    exit;
}

ob_start();

?>

<section id="login-container">
    <div id="user">
        <form method="POST" action="index.php?action=login" enctype="multipart/form-data">
            <label for="email">Email / Nom d'utilisateur :</label>
            <input type="text" id="email" name="email" required autocomplete="off">

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required autocomplete="off">

            <button type="submit" name="login" id="login">Se connecter</button>
        </form>
    </div>
</section>

<?php

$titre = "Connexion";
$titre_secondaire = "Login";
$contenu = ob_get_clean();
require "view/template.php";
