<?php ob_start(); ?>

<!-- Modal addFilm -->

<div class="modal">
    <div onclick="closeModal()" class="modal-close">Retour</div>
    <div class="modal-body">
        <p>
            
        </p>
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
