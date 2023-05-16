<?php ob_start(); ?>

<!-- Modal addFilm -->

<div id="modal" class="modal">
    <div onclick="closeModal()" class="modal-close">Retour</div>
    <div class="modal-body">

        <form action="index.php?action=admin" method="POST" enctype="multipart/form-data">
            <!-- Affiche -->
            <label for="affiche">Affiche :</label>
            <!-- Pour plus tard avec le fichier -->
            <!-- <input type="file" id="affiche" name="affiche" accept="image/png, image/jpeg"> -->
            <input type="text" id="affiche" name="affiche" required maxlength="50" size="20">

            <!-- Titre -->
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required maxlength="50" size="20">

            <!-- Note -->
            <label for="note">Note (1,0 à 5):</label>
            <input type="number" id="note" name="note" min="1.0" max="5.0" step="0.1">

            <!-- Date de Sortie -->
            <label for="dateSortie">Date de Sortie :</label>
            <input type="date" id="dateSortie" name="dateSortie" required size="20">

            <!-- Durée -->
            <label for="duree">Durée :</label>
            <input type="number" id="duree" name="duree" required min="1" step="1">

            <!-- Genre -->
            <fieldset aria-required="true">
                <legend>Genre (minimum 1):</legend>
                <?php 
                    foreach($requeteGenre->fetchAll() as $genre) { ?>
                        <label for="genre<?= $genre['id_genre'];?>"><?= $genre['nom'];?> :</label>
                        <input type="checkbox" id="genre<?= $genre['id_genre'];?>" name="idGenre[]" value="<?= $genre['id_genre'];?>"><br>
                    <?php } ?>
            </fieldset>

            <!-- Synopsis -->
            <label for="synopsis">Synopsis :</label>
            <input type="text" id="synopsis" name="synopsis" required maxlength="2000" size="20">

            <!-- Réalisateur -->
            <label for="realisateur-choice">Réalisateur :</label>
            <input list="nameRealisateur" id="realisateur-choice" name="idRealisateur">
            
            <datalist id="nameRealisateur">
                <?php 
                    foreach($requeteRealisateur->fetchAll() as $realisateur) { ?>
                        <option value="<?=$realisateur['id_realisateur'];?>"><?= $realisateur['name'];?>
                <?php } ?>
            </datalist>
            
            <br>
            <legend>Ajouter un réalisateur</legend>
            <label for="addRealisateur">Nom :</label>
            <input type="text" id="affiche" name="nom" maxlength="50" size="20">
            <label for="addRealisateur">Prénom :</label>
            <input type="text" id="affiche" name="prenom" maxlength="50" size="20">
            <label for="addRealisateur">Sexe (H ou F):</label>
            <input type="text" id="affiche" name="sexe" maxlength="1" size="20">
            <label for="addRealisateur">Date de naissance :</label>
            <input type="date" id="dateSortie" name="dateNaiss" size="20">

            <!-- Bouton ajouter le film -->
            <div class="button">
                <input type="submit" name="filmSubmit" id="submit" Value="Ajouter le film">
            </div>
        </form>

        <!-- Bouton ferme le modal addFilm -->
        <button onclick="closeModal()" class="modal-button">Fermer</button>
    </div>
</div>

<section id="admin">
    <div class="header">
        <div class="lettres">
            <?php
            foreach(range('A', 'Z') as $lettre) { ?>
                <a type="button" class="lettre" href="#<?= $lettre; ?>"><?= $lettre; ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="main">
            <div class="liste">
                <!-- Lettre position verticale avec titre de film trié par ordre alphabétique -->
                <?php
                $titres = $requeteTitres->fetchAll();

                foreach(range('A', 'Z') as $lettre) { ?>
                    <div class="liste-lettre-film">
                        <div class="lettre" id="<?= $lettre; ?>"><?= $lettre; ?></div>
                        <div class="film">
                        <?php
                            foreach($titres as $titre) {
                                $search  = array('À', 'É', 'Ê', "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", " "); // voir REGEX
                                $replace = array('A', 'E', 'E', "", "", "", "", "", "", "", "", "", "", "");
                                $film = str_replace($search, $replace, $titre['titre']);
                                $filmMaj = ucfirst($film);

                                if(substr($filmMaj, 0, 1) === $lettre) { ?>
                                    <div><?= $titre['titre']; ?></div>
                                <?php 
                                }
                            } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Modal : Bouton Ajouter un film -->

                <button onclick="openModal()" class="addFilm">Ajouter un film</button>

            </div>
    </div>
</section>


<?php

$titre = "Admin";
$titre_secondaire = "Admin";
$contenu = ob_get_clean();
require "view/template.php";

