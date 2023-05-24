<?php 

ob_start(); 
$acteur = $requeteAfficherActeur->fetch();

?>

<section id="detail-personne">

        <div>Acteur : <?= $acteur['acteur'];?></div>
        <div>Sexe : <?= $acteur['sexe'];?></div>
        <div>Date de naissance : <?= $acteur['dateNaiss'];?></div>

</section>

<?php

$titre = "Détail de l'acteur : " . $acteur['acteur'];
$titre_secondaire = "Détails acteur";
$contenu = ob_get_clean();
require "view/template.php";