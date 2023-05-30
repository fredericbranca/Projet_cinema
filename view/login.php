<?php

ob_start();

?>

<section id="login">
    <form method="POST" action="index.php?action=login" enctype="multipart/form-data">
        <label for="email">Email / Nom d'utilisateur :</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login" id="login">Se connecter</button>
    </form>
</section>

<?php

$titre = "Connexion";
$titre_secondaire = "Login";
$contenu = ob_get_clean();
require "view/template.php";
