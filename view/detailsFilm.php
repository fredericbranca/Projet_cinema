<?php ob_start(); ?>

<section id="detail-film">
    
    <?php foreach($requeteFilm->fetchAll() as $film) { ?>
        <img src="public/img/<?= $film['affiche'];?>" alt="Affiche du film : <?= $film['titre'];?>">
        <div class="details size">
            <h2><?= $film['titre'];?></h2>
            <div class="note">
                <?php
                $note = $film['note']; 
                for($i = 1; $i <= 5; $i++) {
                    if($i <= $note) {
                        echo '<i class="fa-sharp fa-solid fa-star"></i>';
                    } else {
                        echo '<i class="fa-sharp fa-regular fa-star"></i>';
                    }
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
                <p><span>De </span><?php $rea = $requeteRealisateur->fetch(); echo $rea['rea'];?></p>
                <div class="acteur">
                    <span>Avec</span>
                    <?php 
                    $i = 0;
                    foreach($requeteActeur->fetchAll() as $acteur) {
                        if($i == 0) {
                            echo " " . $acteur['act'] . " (" . $acteur['role'] . ")";
                        } else { echo ", " . $acteur['act'] . " (" . $acteur['role'] . ")"; }
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
$titre = $film['titre'];
$titre_secondaire = "Détails du Film";
$contenu = ob_get_clean();
require "view/template.php";