<?php

ob_start();
$films = $requeteFilms->fetchAll();

?>

<section id="header">
    <div class="header">
        <ul>
            <li>Cinema</li>
            <li>Films</li>
            <li>Référence du Cinéma</li>
            <li>VO</li>
            <li>VOST FR</li>
            <li>VF</li>
        </ul>
        <h1>CNEMA Cretria</h1>
        <p>Site de référence du cinéma !</p>
        <a href="#listFilms">Voir les films récent</a>
    </div>
</section>

<section id="listFilms">
    <div class="blur">
        <div class="header-films">
            <h2>Films récent</h2>
            <div class="whiteline"></div>
        </div>
        <div id="container-film">
            <div class="chevron" id="chevron-gauche"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="chevron" id="chevron-droit"><i class="fa-solid fa-chevron-right"></i></div>
            <div id="caroussel">

                <div class="cards">

                    <?php
                    foreach ($films as $film) { ?>

                        <div class="card-film">
                            <img src="public/img/<?= $film['affiche']; ?>" alt="Affiche du Film : <?= $film['titre']; ?>">
                            <div class="info-film">
                                <h2><?= $film['titre']; ?></h2>
                                <p>
                                    <?php if ($film['duree'] > 59) {
                                        echo $film['dureeFormat'];
                                    } else {
                                        echo $film['duree'] . " MIN";
                                    }; ?>
                                </p>
                                <p>Sortie le <?= $film['dateDeSortie']; ?></p>
                            </div>
                            <a href="index.php?action=detailsFilm&id=<?= $film['id_film'] ?>">Détails du film</a>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php

$titre = "Accueil";
$titre_secondaire = "Liste des Films";
$contenu = ob_get_clean();
require "view/template.php";
