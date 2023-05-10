<?php 

namespace Controller;
use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"

class CinemaController {

    /* Lister les films */
    public function listFilms() {

        $pdo = Connect::seConnecter();
        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");
        $requeteFilms = $pdo->query("
            SELECT id_film, affiche, duree, titre, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, DATE_FORMAT(dateSortie, '%e %M %Y') as dateSortie, titre as test
            FROM film
        ");

        require "view/accueil.php";
    }

    /* Détails des films */
    public function detailsFilm($id) {

        $pdo = Connect::seConnecter();
        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");
        $requeteTitre = $pdo->prepare("
            SELECT titre
            FROM film
            WHERE id_film = :id
        ");
        $requeteFilm = $pdo->prepare("
            SELECT affiche, titre, note, DATE_FORMAT(dateSortie, '%e %M %Y') as dateSortie, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, synopsis
            FROM film
            WHERE id_film = :id
        ");
        $requeteGenre = $pdo->prepare("
            SELECT nom
            FROM genre g
            JOIN genre_film gf ON g.id_genre = gf.id_genre
            JOIN film f ON f.id_film = gf.id_film
            WHERE f.id_film = :id
        ");
        $requeteRealisateur= $pdo->prepare("
            SELECT CONCAT(nom, ' ', prenom) as rea
            FROM personne p
            JOIN realisateur r ON r.id_personne = p.id_personne
            JOIN film f ON f.id_realisateur = r.id_realisateur
            WHERE f.id_film = :id
        ");
        $requeteActeur= $pdo->prepare("
            SELECT CONCAT(p.nom, ' ', p.prenom) as act, r.role as role
            FROM casting c
            JOIN role r ON r.id_role = c.id_role
            JOIN film f ON f.id_film = c.id_film
            JOIN acteur a ON a.id_acteur = c.id_acteur
            JOIN personne p ON a.id_personne = p.id_personne
            WHERE f.id_film = :id
        ");
        $requeteTitre->execute(["id" => $id]);
        $requeteFilm->execute(["id" => $id]);
        $requeteGenre->execute(["id" => $id]);
        $requeteRealisateur->execute(["id" => $id]);
        $requeteActeur->execute(["id" => $id]);
        
        require "view/detailsFilm.php";
    }
}