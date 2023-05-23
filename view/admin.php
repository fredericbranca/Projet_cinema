<?php ob_start(); ?>

<!-- Modal addFilm -->

<div id="modalAddFilm" class="modal">
    <div onclick="closeModal('#modalAddFilm')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form action="index.php?action=admin" method="POST" enctype="multipart/form-data">
            <!-- Affiche -->
            <label for="affiche">Affiche :</label>
            <input type="file" id="affiche" name="affiche" accept="image/png, image/jpeg">

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
                foreach ($requeteGenre->fetchAll() as $genre) { ?>
                    <label for="genre<?= $genre['id_genre']; ?>"><?= $genre['nom']; ?> :</label>
                    <input type="checkbox" id="genre<?= $genre['id_genre']; ?>" name="idGenre[]" value="<?= $genre['id_genre']; ?>"><br>
                <?php } ?>
                <div id="genres-container">
                    <h2>Créer un nouveau genre</h2>
                    <button id="ajouter-genre">+</button>
                </div>

            </fieldset>

            <!-- Synopsis -->
            <label for="synopsis">Synopsis :</label>
            <input type="text" id="synopsis" name="synopsis" required maxlength="2000" size="20">

            <!-- Réalisateur -->
            <label for="idRealisateur">Réalisateur :</label>
            <select id="idRealisateur" name="idRealisateur">
                <option value="">Sélectionner un réalisateur</option>
                <?php foreach ($requeteRealisateur->fetchAll() as $realisateur) { ?>
                    <option value="<?= $realisateur['id_realisateur']; ?>"><?= $realisateur['name']; ?></option>
                <?php } ?>
            </select>

            <br>
            <!-- Ajouter un réalisateur -->
            <legend>Ajouter un réalisateur</legend>
            <!-- Nom -->
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" size="20">
            <!-- Prenom -->
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" size="20">
            <!-- Sexe -->
            <select name="sexe">
                <option name="sexe" value="H">Homme</option>
                <option name="sexe" value="F">Femme</option>
            </select>
            <!-- Date de naissance -->
            <label for="dateNaissance">Date de naissance :</label>
            <input type="date" id="dateNaissance" name="dateNaissance" size="20">

            <!-- Bouton ajouter le film -->
            <div class="button">
                <input type="submit" name="filmSubmit" id="submit" Value="Ajouter le film">
            </div>
        </form>

        <!-- Bouton ferme le modal addFilm -->
        <button onclick="closeModal('#modalAddFilm')" class="modal-button">Fermer</button>
    </div>
</div>

<!-- Modal addCasting -->

<div id="modalAddCasting" class="modal">
    <div onclick="closeModal('#modalAddCasting')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form action="index.php?action=admin" method="POST" enctype="multipart/form-data">
            <p>Ajout d'un casting pour le film : 
            <? 
            if (!empty($_SESSION['titre'])) {
                echo $_SESSION['titre']; 
            } ?>
            </p>

            <!-- Selection acteur(s) existant -->
            <?php
                $acteurs = $requeteActeur->fetchAll();
                $acteursJSON = json_encode($acteurs); // json_encode() permet de convertir une valeur PHP en une chaîne JSON
            ?>
            <div id="acteurs-select-container">
                <legend>Ajouter un/des acteur(s) existant dans la base de données</legend>
                <button id="ajouter-select-acteur">+</button>
                <div class="acteurs-select">

                </div>
            </div>
            


            <div id="acteurs-input-container">
                <!-- Ajouter acteur(s) -->
                <legend>Ajouter un ou plusieurs acteur(s)</legend>
                <button id="ajouter-acteur">+</button>

                <div class="acteur-input">

                </div>
            </div>

            <!-- Bouton ajouter le film -->
            <div class="button">
                <input type="submit" name="castingSubmit" id="submit" Value="Ajouter le casting au film">
            </div>
        </form>

        <!-- Bouton ferme le modal addFilm -->
        <button onclick="closeModal('#modalAddCasting')" class="modal-button">Fermer</button>
    </div>
</div>

<!-- Modal supprimer film 

<div id="modalDelFilm" class="modalDeleteFilm">
    <div class="modal-body">
        <div>Voulez-vous vraiment supprimer le film : ... ?</div>
        <div class="bouton">
            <div>Oui</div>
            <div onclick="closeModal('#modalDelFilm')" class="modal-close">Non</div>
        </div>
    </div>
</div> -->


<section id="admin">
    <div class="header">
        <div class="lettres">
            <?php
            foreach (range('A', 'Z') as $lettre) { ?>
                <a type="button" class="lettre" href="#<?= $lettre; ?>"><?= $lettre; ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="main">
        <div class="liste">
            <!-- Lettre position verticale avec titre de film trié par ordre alphabétique -->
            <?php
            $titres = $requeteTitres->fetchAll();

            foreach (range('A', 'Z') as $lettre) { ?>
                <div class="liste-lettre-film">
                    <div class="lettre" id="<?= $lettre; ?>"><?= $lettre; ?></div>
                    <div class="film">
                        <?php
                        foreach ($titres as $titre) {
                            $search  = array('À', 'É', 'Ê', "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", " "); // voir REGEX
                            $replace = array('A', 'E', 'E', "", "", "", "", "", "", "", "", "", "", "");
                            $film = str_replace($search, $replace, $titre['titre']);
                            $filmMaj = ucfirst($film);

                            if (substr($filmMaj, 0, 1) === $lettre) { ?>
                                <div class="titreFilm" onclick="afficherMenuDeroulant('#menuId<?=$titre['id_film'];?>')"><?= $titre['titre']; ?></div>
                                <div id="menuId<?= $titre['id_film'];?>" style="display: none;">
                                    <form action="index.php?action=admin" method="POST" enctype="multipart/form-data">
                                        <input type="submit" name="modifierFilmSubmit" id="submit" value="Modifier">
                                    </form>
                                    <form action="index.php?action=admin&id=<?= $titre['id_film'];?>" method="POST" enctype="multipart/form-data">
                                        <input type="submit" name="supprimerFilmSubmit" id="submit" value="Supprimer">
                                    </form>
                                </div>
                        <?php
                            }
                        } ?>
                    </div>
                </div>
            <?php } ?>

            <!-- Modal : Bouton Ajouter un film -->

            <button onclick="openModal('#modalAddFilm')" class="addFilm">Ajouter un film</button>

        </div>
    </div>
</section>

<script>
  var acteursData = <?php echo $acteursJSON; ?>;
</script>

<?php

$titre = "Admin";
$titre_secondaire = "Admin";
$contenu = ob_get_clean();
require "view/template.php";
