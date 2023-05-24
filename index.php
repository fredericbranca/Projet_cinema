<?php 

session_start();

use Controller\CinemaController; // On "use" le controller Cinema
use Controller\ActeurController;
use Controller\RealisateurController;
use Controller\GenreController;

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); // On instancie le controller Cinema
$ctrlActeur = new ActeurController(); 
$ctrlRealisateur = new RealisateurController();
$ctrlGenre = new GenreController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null;

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {

        // CinemaController
        case "accueil" : $ctrlCinema -> listFilms(); break;
        case "detailsFilm" : $ctrlCinema -> detailsFilm($id); break;
        case "admin" : $ctrlCinema -> addFilm(); break;
        case "modifierFilm" : $ctrlCinema -> modifierFilm($id); break;

        // ActeurController
        case "detailsActeur" : $ctrlActeur -> detailsActeur($id); break;

        // RealisateurController
        case "detailsRealisateur" : $ctrlRealisateur -> detailsRealisateur($id); break;

        // GenreController
        case "listGenres" : $ctrlGenre -> listGenres(); break;
        case "listFilmsGenre" : $ctrlGenre -> listFilmsGenre($id); break;
    }
}