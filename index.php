<?php 

session_start();

use Controller\CinemaController; // On "use" le controller Cinema
use Controller\ActeurController;
use Controller\RealisateurController;
use Controller\ListeFilmsController;
use Controller\AuthentificationController;
use Controller\ProfilController;


// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); // On instancie le controller Cinema
$ctrlActeur = new ActeurController(); 
$ctrlRealisateur = new RealisateurController();
$ctrlFilms = new ListeFilmsController();
$ctrlAuthentification = new AuthentificationController();
$ctrlProfil = new ProfilController();


$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$genreFiltre = isset($_GET['genre']) ? $_GET['genre'] : null;
$yearFiltre = isset($_GET['year']) ? $_GET['year'] : null;

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

        // ListFilmsController
        case "listFilms" : $ctrlFilms -> listFilms($id, $genreFiltre, $yearFiltre); break;

        // AuthentificationController
        case "login" : $ctrlAuthentification -> login(); break;
        case "register" : $ctrlAuthentification -> register(); break;
        case "logout" : $ctrlAuthentification -> logout(); break;

        // ProfilController
        case "profil" : $ctrlProfil -> profil(); break;
        case "delete-account" : $ctrlProfil -> deleteAcc(); break;
    }
}