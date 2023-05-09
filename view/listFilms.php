<?php ob_start(); ?>

<section id="header">
    <ul>
        <li>Cinema</li>
        <li>Films</li>
        <li>Référence du Cinéma</li>
        <li>VO</li>
        <li>VOST FR</li>
        <li>VF</li>
    </ul>
</section>

<?php

$titre = "Accueil";
$titre_secondaire = "Liste des Films";
$contenu = ob_get_clean();
require "view/template.php";