<?php 

session_start();

use Controller\CinemaController; // On "use" le controller Cinema
use Controller\ActeurController;
use Controller\RealisateurController;

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); // On instancie le controller Cinema
$ctrlActeur = new ActeurController();
$ctrlRealisateur = new RealisateurController();


$id = (isset($_GET["id"])) ? $_GET["id"] : null;

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {

        // CinemaController
        case "accueil" : $ctrlCinema -> listFilms(); break;
        case "detailsFilm" : $ctrlCinema -> detailsFilm($id); break;
        case "admin" : $ctrlCinema -> addFilm(); break;

        //ActeurController
        case "detailsActeur" : $ctrlActeur -> listActeurs($id); break;

        //RealisateurController
        case "detailsRealisateur" : $ctrlRealisateur -> listRealisateurs($id); break;
    }
}