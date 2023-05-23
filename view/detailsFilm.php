<?php 
ob_start(); 
$rea = $requeteRealisateur->fetch();
?>

<section id="detail-film">
    
    <?php foreach($requeteFilm->fetchAll() as $film) { ?>
        <img src="public/img/<?= $film['affiche'];?>" alt="Affiche du film : <?= $film['titre'];?>">
        <div class="details size">
            <h2><?= $film['titre'];?></h2>
            <div class="note">
                <?php
                $note = $film['note'];
                $nbEtoile = floor($film['note']);
                $nbDemiEtoile = ($note - $nbEtoile >= 0.2 && $note - $nbEtoile <= 0.8);
                $nbEtoileSupp = ($note - $nbEtoile > 0.8);
                
                for($i = 1; $i <= $note; $i++) {
                        echo '<i class="fa-sharp fa-solid fa-star"></i>';
                    }
                if($nbDemiEtoile) {
                    echo '<i class="fa-regular fa-star-half-stroke"></i>';
                }
                if($nbEtoileSupp) {
                    echo '<i class="fa-sharp fa-solid fa-star"></i>';
                }
                $nbEtoileVide = 5 - $nbEtoile - ($nbDemiEtoile ? 1 : 0) - ($nbEtoileSupp ? 1 : 0);
                for ($i = 1; $i <= $nbEtoileVide; $i++) {
                        echo '<i class="fa-sharp fa-regular fa-star"></i>';
                } ?>
                
                (<?= $film['note'];?>) 
            </div>
            <div>
                <p><span>Sortie le </span><?= $film['dateSortie'];?></p>
                <ul class="genre"><?php 
                    foreach($requeteGenre->fetchAll() as $genre) {
                        echo "<li>" . $genre['nom'] . "</li>";
                    } ?>
                    <li>(<?= $film['dureeFormat'];?>)</li>
                </ul>
            </div>
            <div>
                <p><span>De </span><a href="index.php?action=detailsRealisateur&id=<?= $rea['idRealisateur']?>"><?= $rea['rea'] ?></a></p>
                <div class="acteur">
                    <span>Avec</span>
                    <?php 
                    $i = 0;
                    foreach($requeteActeur->fetchAll() as $acteur) {
                        if($i == 0) {
                            echo ' <a href="index.php?action=detailsActeur&id=' . $acteur['idActeur'] . '">' . $acteur['act'] . '</a> (' . $acteur['role'] . ')';
                        } else { echo ', <a href="index.php?action=detailsActeur&id=' . $acteur['idActeur'] . '">' . $acteur['act'] . '</a> (' . $acteur['role'] . ')'; }
                        $i = 1;
                    } ?>
                </div>
            </div>
            <div class="synopsis">
                <span>Synopsis</span>
                <p><?= $film['synopsis'];?></p>
            </div>
        </div>
    <?php } ?>

</section>

<?php

$RTitre = $requeteTitre->fetch();
$titre = "Détails du film : " . $film['titre'];
$titre_secondaire = "Détails du Film";
$contenu = ob_get_clean();
require "view/template.php";