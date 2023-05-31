<?php

if (isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
    
ob_start();



$realisateurs = $requeteRealisateur->fetchAll(); // récupère tous les réalisateurs
$acteurs = $requeteActeur->fetchAll(); // récupère tous les acteurs
$roles = $requeteRole->fetchAll(); // récupère tous roles
$casting = $requeteCasting->fetchAll(); // récupère le casting d'un film
$film = $requeteFilm->fetch(); // récupère toutes les infos d'un film
$genresFilm = $requeteGenreFilm->fetchAll(); // récupère tous les genres d'un film
$listGenres = $requeteGenres->fetchAll(); // récupère tous les genres

$genresJSON = json_encode($listGenres); // json_encode() permet de convertir une valeur PHP en une chaîne JSON
$acteursJSON = json_encode($acteurs);
$rolesJSON = json_encode($roles);

?>

<!-- Modal Créer un Nouveau Genre -->

<div id="modalAddGenre" class="modal2">
    <div onclick="closeModal('#modalAddGenre')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form id="formAddGenre" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
            <p>Ajouter un genre</p>

            <!-- Ajouter Genre -->
            <div>
                <input type="text" name="genre" placeholder="Nom du genre" minlength="1" maxlength="50" size="20" required>
            </div>

            <!-- Bouton ajouter le genre -->
            <div class="buttonHidden">
                <input type="submit" name="addGenreSubmit" id="addGenreSubmit" Value="Ajouter le genre">
            </div>
            <div class="button">
                <button onclick="checkAndOpenModalConfirmation(event, 'addGenreSubmit', 'formAddGenre')" id="addGenreButton">Ajouter le genre</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Créer un Nouveau Réalisateur -->

<div id="modalAddRealisateur" class="modal2">
    <div onclick="closeModal('#modalAddRealisateur')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form id="formAddRealisateur" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
            <p>Ajouter un réalisateur</p>

            <!-- Ajouter Realisateur -->
            <div class="addPersonne">
                <!-- Nom -->
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required minlength="1" maxlength="50" size="20">
                <!-- Prenom -->
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required minlength="1" maxlength="50" size="20">
                <!-- Sexe -->
                <legend>Sexe</legend>
                <select name="sexe">
                    <option name="sexe" value="H">Homme</option>
                    <option name="sexe" value="F">Femme</option>
                </select>
                <!-- Date de naissance -->
                <label for="dateNaissance">Date de naissance</label>
                <input type="date" id="dateNaissance" name="dateNaissance" required size="20">
            </div>

            <!-- Bouton ajouter le réalisateur -->
            <div class="buttonHidden">
                <input type="submit" name="addRealisateurSubmit" id="addRealisateurSubmit" Value="Ajouter le réalisateur">
            </div>
            <div class="button">
                <button onclick="checkAndOpenModalConfirmation(event, 'addRealisateurSubmit', 'formAddRealisateur')" id="addRealisateurButton">Ajouter le réalisateur</button>
            </div>
        </form>

        <!-- Bouton ferme le modal -->
        <button onclick="closeModal('#modalAddRealisateur')" class="modal-button">Fermer</button>
    </div>
</div>

<!-- Modal Créer un nouvel acteur -->

<div id="modalAddActeur" class="modal2">
    <div onclick="closeModal('#modalAddActeur')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form id="formAddActeur" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
            <p>Ajouter un acteur</p>

            <!-- Ajouter Acteur -->
            <div class="addPersonne">
                <!-- Nom -->
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required minlength="1" maxlength="50" size="20">
                <!-- Prenom -->
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required minlength="1" maxlength="50" size="20">
                <!-- Sexe -->
                <legend>Sexe</legend>
                <select name="sexe">
                    <option name="sexe" value="H">Homme</option>
                    <option name="sexe" value="F">Femme</option>
                </select>
                <!-- Date de naissance -->
                <label for="dateNaissance">Date de naissance</label>
                <input type="date" id="dateNaissance" name="dateNaissance" required size="20">
            </div>

            <!-- Bouton ajouter l'acteur -->
            <div class="buttonHidden">
                <input type="submit" name="addActeurSubmit" id="addActeurSubmit" Value="Ajouter l'acteur'">
            </div>
            <div class="button">
                <button onclick="checkAndOpenModalConfirmation(event, 'addActeurSubmit', 'formAddActeur')" id="addActeurButton">Ajouter l'acteur'</button>
            </div>
        </form>

        <!-- Bouton ferme le modal addFilm -->
        <button onclick="closeModal('#modalAddActeur')" class="modal-button">Fermer</button>
    </div>
</div>

<!-- Modal Créer un Nouveau rôle -->

<div id="modalAddRole" class="modal2">
    <div onclick="closeModal('#modalAddRole')" class="modal-close">Retour</div>
    <div class="modal-body">

        <form id="formAddRole" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
            <p>Ajouter un rôle</p>

            <!-- Ajouter Role -->
            <div>
                <input type="text" name="role" placeholder="Nom du rôle" minlength="1" maxlength="50" size="20" required>
            </div>

            <!-- Bouton ajouter le rôle -->
            <div class="buttonHidden">
                <input type="submit" name="addRoleSubmit" id="addRoleSubmit" Value="Ajouter le rôle">
            </div>
            <div class="button">
                <button onclick="checkAndOpenModalConfirmation(event, 'addRoleSubmit', 'formAddRole')" id="addRoleButton">Ajouter le rôle</button>
            </div>
        </form>

        <!-- Bouton ferme le modal -->
        <button onclick="closeModal('#modalAddRole')" class="modal-button">Fermer</button>
    </div>
</div>

<section id="modifier-film">

    <button onclick="openModal('#modalAddGenre')" class="addGenre">Ajouter un genre</button> <!-- Modal : Bouton Ajouter un genre -->
    <button onclick="openModal('#modalAddRealisateur')" class="addRealisateur">Ajouter un réalisateur</button> <!-- Modal : Bouton Ajouter un réalisateur -->
    <button onclick="openModal('#modalAddActeur')" class="addActeur">Ajouter un acteur</button> <!-- Modal : Bouton Ajouter un acteur -->
    <button onclick="openModal('#modalAddRole')" class="addRole">Ajouter un rôle</button> <!-- Modal : Bouton Ajouter un rôle -->

    <form class="formulaire" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">

        <div>
            <div class="affiche">
                <!-- Affiche -->
                <img src="public/img/<?= $film['affiche']; ?>" alt="Affiche du Film : <?= $film['titre']; ?>">
                <label for="affiche">Affiche :</label>
                <input name="affiche" type="file" accept="image/*" onchange="loadFile(event)">
                <img id="output" />
                <script> // script pour avoir le preview de l'affiche insérée
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                            URL.revokeObjectURL(output.src) // free memory
                        }
                    };
                </script>
            </div>
        </div>

        <div>
            <!-- Titre -->
            <div class="titre">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" required minlength="1" maxlength="50" size="30" value="<?= $film['titre'] ?>">
            </div>

            <!-- Note -->
            <div class="note">
                <label for="note">Note</label>
                <input type="number" id="note" name="note" required min="0" max="5" size="30" step="0.1" value="<?= $film['note'] ?>">
            </div>

            <!-- Durée -->
            <div class="duree">
                <label for="duree">Durée (minutes) :</label>
                <input type="number" id="duree" name="duree" required min="1" step="1" value="<?= $film['duree'] ?>">
            </div>

            <!-- Date de sortie -->
            <div class="dateSortie">
                <label for="dateSortie">Date de sortie</label>
                <input type="date" id="dateSortie" name="dateSortie" required size="30" value="<?= $film['dateSortie'] ?>">
            </div>


            <!-- Réalisateur -->
            <div class="realisateur">
                <label for="realisateur">Réalisateur</label>
                <select id="realisateur" name="realisateur">
                    <option value="">Sélectionner un réalisateur</option>
                    <?php
                    foreach ($realisateurs as $realisateur) {
                        $selected = ($film['id_realisateur'] == $realisateur['id_realisateur']) ? "selected" : "";
                    ?>
                        <option value="<?= $realisateur['id_realisateur'] ?>" <?= $selected ?>><?= $realisateur['realisateur']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div>
            <!-- Genre -->
            <fieldset class="genre">
                <legend>Genre (minimum 1):</legend>
                <?php
                foreach ($listGenres as $genre) {
                    foreach ($genresFilm as $genreFilm) {
                        $checked = ($genreFilm['id_genre'] == $genre['id_genre']) ? "checked" : ""; // compare les id des genres pour ajouté checked
                        if ($checked == "checked") {
                            break;
                        }
                    }
                ?>
                    <div>
                        <label for="genre<?= $genre['id_genre']; ?>"><?= $genre['nom']; ?> :</label>
                        <input type="checkbox" id="genre<?= $genre['id_genre']; ?>" name="genre[]" value="<?= $genre['id_genre']; ?>" <?= $checked ?>>
                    </div>
                <?php
                }
                ?>
            </fieldset>
        </div>

        <div>
            <!-- Casting(s) -->
            <div id="modifierFilmCasting">
                <div class="label">
                    <p>Acteur</p>
                    <p>Rôle</p>
                    <button id="ajouter-casting">+</button>
                </div>
                <?php
                foreach ($casting as $casting) {
                ?>
                    <div id="casting">
                        <div id="acteurRole">
                            <!-- Acteur(s) -->
                            <div class="acteur-select">
                                <select id="acteur" name="acteur[]">
                                    <option value="">Sélection d'un acteur</option>
                                    <?php
                                    foreach ($acteurs as $acteur) {
                                        $selected = ($casting['id_acteur'] == $acteur['id_acteur']) ? "selected" : "";
                                    ?>
                                        <option value="<?= $acteur['id_acteur'] ?>" <?= $selected ?>><?= $acteur['acteur']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Rôle -->
                            <div class="role-select">
                                <select id="role" name="role[]">
                                    <option value="">Sélection d'un role</option>
                                    <?php
                                    foreach ($roles as $role) {
                                        $selected = ($casting['id_role'] == $role['id_role']) ? "selected" : "";
                                    ?>
                                        <option value="<?= $role['id_role'] ?>" <?= $selected ?>><?= $role['role']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button id="supprimer-casting">-</button>

                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Synopsis -->
            <div class="synopsis">
                <label for="synopsis">Synopsis</label>
                <textarea id="synopsis" name="synopsis" required minlength="1" maxlength="2000"><?= $film['synopsis'] ?></textarea>
            </div>
        </div>

        <!-- Bouton submit -->
        <div class="button">
            <input type="submit" name="updateSubmit" id="submit" Value="Modifier le film">
        </div>

        </div>
    </form>
</section>

<script>
    var genresData = <?php echo $genresJSON; ?>;
    var acteursData = <?php echo $acteursJSON; ?>;
    var rolesData = <?php echo $rolesJSON; ?>;
</script>

<?php

// redirection si l'utilisateur connecté n'est pas admin
} else {
    $_SESSION['messageError'] = "Vous n'avez pas les droits d'accès à cette page";
    header("Location: index.php?action=accueil");
    exit;
}

$titre = "Modifier film : " . $film['titre'];
$titre_secondaire = "Modification des films";
$contenu = ob_get_clean();
require "view/template.php";
