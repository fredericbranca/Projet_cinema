<?php ob_start(); ?>

<section id="detail-acteur">

    <?php
    $detailsActeur = $requeteAfficherRealisateur->fetchAll();

    foreach($detailsActeur as $acteur) { ?>
        <div>Réalisateur : <?= $acteur['realisateur'];?></div>
        <div>Sexe : <?= $acteur['sexe'];?></div>
        <div>Date de naissance : <?= $acteur['dateNaiss'];?></div>
    <?php } ?>

</section>

<?php

$titre = "Détail du réalisateur : " . $detailsActeur['realisateur'];
$titre_secondaire = "Détails réalisateur";
$contenu = ob_get_clean();
require "view/template.php";