<?php ob_start(); ?>

<section id="detail-acteur">

    <?php
    $detailsActeur = $requeteAfficherActeur->fetchAll();

    foreach($detailsActeur as $acteur) { ?>
        <div>Acteur : <?= $acteur['acteur'];?></div>
        <div>Sexe : <?= $acteur['sexe'];?></div>
        <div>Date de naissance : <?= $acteur['dateNaiss'];?></div>
    <?php } ?>

</section>

<?php

$titre = "Détail de l'acteur : " . $detailsActeur['acteur'];
$titre_secondaire = "Détails acteur";
$contenu = ob_get_clean();
require "view/template.php";