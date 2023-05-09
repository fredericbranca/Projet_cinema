<?php ob_start(); ?>

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
        <form action="">
            <input type="submit" name="submit" id="submit" Value="Cinéma à proximité">
        </form>
    </div>
</section>

<section id="listFilms">
    <div class="header-films">
        <h2>Films</h2>
        <div class="whiteline"></div>
    </div>
    <div id="container-film">
        <div class="chevron" id="chevron-gauche"><i class="fa-solid fa-chevron-left"></i></div>
        <div class="chevron" id="chevron-droit"><i class="fa-solid fa-chevron-right"></i></div>
        <div id="caroussel">

            <div class="cards">

        <?php
        foreach($requeteFilms->fetchAll() as $film) { ?>
            
            <form action="index.php?action=detailsFilm&id=<?= $film['id_film'] ?>" method="POST" enctype="multipart/form-data">
                <div class="card-film">
                    <img src="public/img/<?= $film['affiche'];?>" alt="Affiche du Film : <?= $film['titre'];?>">
                    <div class="info-film">
                        <h2><?= $film['titre'];?></h2>
                        <p>
                            <?php if($film['duree'] > 59) {
                                    echo $film['dureeFormat'];
                                }
                                else {echo $film['duree'] . " MIN";};?>
                        </p>
                        <p>Sortie le <?= $film['dateSortie'];?></p>
                    </div>
                    <input type="submit" name="submit" id="submit" Value="Détails du film">
                </div> 
            </form>
        <?php } ?>

            </div>
        </div>
    </div>
</section>

<?php

$titre = "Accueil";
$titre_secondaire = "Liste des Films";
$contenu = ob_get_clean();
require "view/template.php";