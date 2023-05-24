<?php

ob_start();
$films = $requeteAfficherFilmsGenre->fetchAll();
$genre = $requeteGenre->fetch();
?>

<section id="list-genres">
    <div class="genres">
        <h1><?= $genre['nom'] ?> : Liste des films</h1>
        <?php
        foreach ($films as $film) { ?>
            <a href="index.php?action=detailsFilm&id=<?= $film['idFilm'] ?>"><?= $film['titre'] ?></a>
        <?php
        }
        ?>
    </div>
</section>

<?php

$titre = $genre['nom'] . " : Liste films";
$titre_secondaire = "Liste des films par genre";
$contenu = ob_get_clean();
require "view/template.php";