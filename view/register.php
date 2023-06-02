<?php

if (isset($_SESSION['user'])) {
    $_SESSION['messageError'] = "Page inaccessible, vous êtes déjà connecté.";
    header("Location: index.php?action=accueil");
    exit;
}

ob_start();

?>

<section id="register-container">
    <div id="user">
        <form method="POST" action="index.php?action=register" enctype="multipart/form-data">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required autocomplete="off">

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required autocomplete="off">

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required autocomplete="off">

            <label for="confirm_password">Confirmez le mot de passe :</label autocomplete="off">
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit" name="register" id="register">S'inscrire</button>
        </form>
    </div>
</section>

<?php

$titre = "Inscription";
$titre_secondaire = "Register";
$contenu = ob_get_clean();
require "view/template.php";
