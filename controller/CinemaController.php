<?php 

namespace Controller;
use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"

class CinemaController {

    /* Lister les films */
    public function accueil() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT affiche, titre, duree, dateSortie
            FROM film
            ORDER BY dateSortie DESC
        ");

        require "view/accueil.php";
    }

    /* Lister les films */
    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT f.titre, p.nom, p.prenom, r.role
            FROM casting c
            JOIN acteur a ON a.id_acteur = c.id_acteur
            JOIN personne p ON p.id_personne = a.id_personne
            JOIN film f ON f.id_film = c.id_film
            JOIN role r ON r.id_role = c.id_role
            ORDER BY f.titre ASC
        ");

        require "view/listActeurs.php";
    }
}