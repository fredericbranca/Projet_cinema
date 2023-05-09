<?php 

use Controller\CinemaController; // On "use" le controller Cinema

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController(); // On instancie le controller Cinema

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {
        case "accueil" : $ctrlCinema -> accueil(); break;
        case "listActeurs" : $ctrlCinema -> listActeurs(); break;
    }
}