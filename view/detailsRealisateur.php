<?php 

ob_start();
$realisateur = $requeteAfficherRealisateur->fetch();

?>

<section id="detail-personne">
        <div>Réalisateur : <?= $realisateur['realisateur'];?></div>
        <div>Sexe : <?= $realisateur['sexe'];?></div>
        <div>Date de naissance : <?= $realisateur['dateNaiss'];?></div>
</section>

<?php

$titre = "Détail du réalisateur : " . $realisateur['realisateur'];
$titre_secondaire = "Détails réalisateur";
$contenu = ob_get_clean();
require "view/template.php";