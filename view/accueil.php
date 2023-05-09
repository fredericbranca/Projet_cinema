<?php ob_start(); ?>

<section id="header">
    <div class="header">
        <ul>
            <li>Cinema</li>
            <li>Films</li>
            <li>Référence du Cinéma</li>
            <li>VO</li>
            <li>VOST FR</li>
            <li>VF</li>
        </ul>
        <h1>CNEMA Cretria</h1>
        <p>Site de référence du cinéma !</p>
        <form action="">
            <input type="submit" name="join" id="submit" Value="Cinéma à proximité">
        </form>
    </div>
</section>

<?php

$titre = "Accueil";
$titre_secondaire = "Liste des Films";
$contenu = ob_get_clean();
require "view/template.php";
