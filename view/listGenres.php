<?php

ob_start();
$genres = $requeteAfficherGenres->fetchAll();

?>

<section id="list-genres">
    <div class="genres">
        <h1>Liste des genres</h1>
        <?php
        foreach ($genres as $genre) { ?>
            <a href="index.php?action=listFilmsGenre&id=<?= $genre['id_genre'] ?>"><?= $genre['nom'] ?></a>
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