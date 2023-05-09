<?php 

namespace Controller;
use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"

class CinemaController {

    /* Lister les films */
    public function listFilms() {

        $pdo = Connect::seConnecter();
        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");
        $requeteFilms = $pdo->query("
            SELECT id_film, affiche, duree, titre, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, DATE_FORMAT(dateSortie, '%e %M %Y') as dateSortie
            FROM film
        ");

        require "view/accueil.php";
    }

    /* Lister les films */
    // public function detailsFilm($id) {

    //     $pdo = Connect::seConnecter();
    //     $requete = $pdo->query("
    //         SELECT affiche
    //         FROM film
    //     ");
    //     $requete->execute(["id" => $id]);

    //     require "view/detailsFilm.php";
    // }
}