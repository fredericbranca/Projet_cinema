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

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";