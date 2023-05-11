<?php 

use Controller\CinemaController; // On "use" le controller Cinema

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); // On instancie le controller Cinema

$id = (isset($_GET["id"])) ? $_GET["id"] : null;

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {
        case "accueil" : $ctrlCinema -> listFilms(); break;
        case "detailsFilm" : $ctrlCinema -> detailsFilm($id); break;
        case "admin" : $ctrlCinema -> addFilm(); break;
    }
}