<?php

ob_start();

?>

<section id="register">
    <form method="POST" action="index.php?action=register" enctype="multipart/form-data">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" name="register" id="register">S'inscrire</button>
    </form>
</section>

<?php

$titre = "Inscription";
$titre_secondaire = "Register";
$contenu = ob_get_clean();
require "view/template.php";
