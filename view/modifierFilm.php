<?php

ob_start();

$realisateurs = $requeteRealisateur->fetchAll(); // récupère tous les réalisateurs
$acteurs = $requeteActeur->fetchAll(); // récupère tous les acteurs
$roles = $requeteRole->fetchAll(); // récupère tous roles
$casting = $requeteCasting->fetchAll(); // récupère le casting d'un film
$film = $requeteFilm->fetch(); // // récupère toutes les infos d'un film
$genresFilm = $requeteGenreFilm->fetchAll(); // récupère tous les genres d'un film
$listGenres = $requeteGenres->fetchAll(); // récupère tous les genres

$genresJSON = json_encode($listGenres); // json_encode() permet de convertir une valeur PHP en une chaîne JSON
$acteursJSON = json_encode($acteurs);
$rolesJSON = json_encode($roles);

?>

<section id="modifier-film">
    <form class="formulaire" action="index.php?action=modifierFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
        <!-- Titre -->
        <div class="titre">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required minlength="1" maxlength="50" size="30" value="<?= $film['titre'] ?>">
        </div>

        <!-- Note -->
        <div class="note">
            <label for="note">Note</label>
            <input type="number" id="note" name="note" required min="0" max="5" size="30" value="<?= $film['note'] ?>">
        </div>

        <!-- Date de sortie -->
        <div class="dateSortie">
            <label for="dateSortie">Date de sortie</label>
            <input type="date" id="dateSortie" name="dateSortie" required size="30" value="<?= $film['dateSortie'] ?>">
        </div>

        <!-- Genre -->
        <div id="modifierFilmGenre" class="genre">
            <label>Genre <button id="ajouter-genre">+</button></label>
            <?php
            foreach ($genresFilm as $genreFilm) {
            ?>
                <div class="genre-select">
                    <select id="genre" name="genre[]">
                        <option value="">Sélection d'un genre</option>
                        <?php
                        foreach ($listGenres as $genre) {
                            $selected = ($genreFilm['id_genre'] == $genre['id_genre']) ? "selected" : ""; // compare les id des genres pour ajouté selected ou non à l'option
                        ?>
                            <option value="<?= $genre['id_genre'] ?>" <?= $selected ?>><?= $genre['nom']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <button id="supprimer-genre">-</button>
                </div>
            <?php
            }
            ?>
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

        <!-- Bouton submit -->
        <div class="button">
            <input type="submit" name="updateSubmit" id="submit" Value="Modifier le film">
        </div>
    </form>
</section>

<script>
    var genresData = <?php echo $genresJSON; ?>;
    var acteursData = <?php echo $acteursJSON; ?>;
    var rolesData = <?php echo $rolesJSON; ?>;
</script>

<?php

$titre = "Modifier film : " . $film['titre'];
$titre_secondaire = "Modification des films";
$contenu = ob_get_clean();
require "view/template.php";
