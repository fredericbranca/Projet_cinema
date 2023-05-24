<?php
ob_start();
$realisateur = $requeteRealisateur->fetch(); // Récupération des données du réalisateur
$film = $requeteFilm->fetch(); // Récupération des données de la table film
$genres = $requeteGenre->fetchAll(); // Récupération des genres du film
$acteurs = $requeteActeur->fetchAll() // Récupération des acteurs ayant joué dans le film
?>

<section id="detail-film">
    <img src="public/img/<?= $film['affiche']; ?>" alt="Affiche du film : <?= $film['titre']; ?>">
    <div class="details size">
        <h2><?= $film['titre']; ?></h2>
        <div class="note">
            <?php
            // Cette partie en PHP permet d'afficher la note du film sous forme d'étoile(s)
            $note = $film['note'];
            $nbEtoile = floor($film['note']); // Note entier inférieur
            $demiEtoile = ($note - $nbEtoile >= 0.2 && $note - $nbEtoile <= 0.8); // Booléen (0.2 <= note <= 0.8)
            $etoileSupp = ($note - $nbEtoile > 0.8); // Booléen (décimale note > 0.8)

            for ($i = 1; $i <= $note; $i++) {
            ?>
                <i class="fa-sharp fa-solid fa-star"></i> <!-- Etoile complète -->
            <?php
            }

            if ($demiEtoile) {
            ?>
                <i class="fa-regular fa-star-half-stroke"></i> <!-- Demi étoile -->
            <?php
            }

            if ($etoileSupp) {
            ?>
                <i class="fa-sharp fa-solid fa-star"></i> <!-- Etoile complète supplémentaire -->
            <?php
            }

            $nbEtoileVide = 5 - $nbEtoile - ($demiEtoile ? 1 : 0) - ($etoileSupp ? 1 : 0); // calcul le nombre d'étoile vide nécessaire pour compléter la note sur 5 étoiles

            for ($i = 1; $i <= $nbEtoileVide; $i++) {
            ?>
                <i class="fa-sharp fa-regular fa-star"></i> <!-- Etoile(s) vide(s) si nécessaire -->
            <?php
            }
            ?>

            (<?= $film['note']; ?>)
        </div>
        <div>
            <p><span>Sortie le </span><?= $film['dateSortie']; ?></p> <!-- Affichage date de sortie du film -->
            <ul class="genre">
                <?php                           // Affichage du/des genre(s) du film
                foreach ($genres as $genre) { 
                ?>
                    <li><a href="index.php?action=listFilmsGenre&id=<?= $genre['id_genre']?>"><?= $genre['nom'] ?></a></li>
                <?php
                }
                ?>
                <li>(<?= $film['dureeFormat']; ?>)</li> <!-- Affichage de la durée du film -->
            </ul>
        </div>
        <div>
            <p><span>De </span><a href="index.php?action=detailsRealisateur&id=<?= $realisateur['idRealisateur'] ?>"><?= $realisateur['realisateur'] ?></a></p> <!-- Affichage du réalisateur -->
            <div class="acteur">
                <span>Avec</span>
                <?php
                $i = 0;
                foreach ($acteurs as $acteur) { // Affichage des acteurs principaux ayant joué dans le film ainsi que leur rôle
                    if ($i == 0) {
                ?>
                        <a href="index.php?action=detailsActeur&id=<?= $acteur['idActeur'] ?>"><?= $acteur['acteur'] ?></a> (<?= $acteur['role'] ?>)
                    <?php
                    } else {
                    ?>
                        <a href="index.php?action=detailsActeur&id=<?= $acteur['idActeur'] ?>"><?= $acteur['acteur'] ?></a> (<?= $acteur['role'] ?>)
                <?php
                    }
                    $i = 1;
                }
                ?>
            </div>
        </div>
        <div class="synopsis">
            <span>Synopsis</span>
            <p><?= $film['synopsis']; ?></p> <!-- Affichage du synopsis du film -->
        </div>
    </div>
</section>



<?php

$titre = "Détails du film : " . $film['titre'];
$titre_secondaire = "Détails du Film";
$contenu = ob_get_clean();
require "view/template.php";
