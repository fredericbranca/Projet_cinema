<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ListeFilmsController
{

    /* Lister les films */
    public function listFilms($id, $genreFiltre, $yearFiltre)
    {
        $pdo = Connect::seConnecter();

        // Requete pour récupérer les infos de la table film
        $requeteAfficherFilms = $pdo->query("
            SELECT *, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, DATE_FORMAT(dateSortie, '%e %M %Y') as dateDeSortie
            FROM film f
            ORDER BY note DESC, titre ASC
        ");

        // Requete pour récupérer les genres avec les id des films
            $requeteAfficherFilmsGenres = $pdo->query("
            SELECT f.id_film, g.id_genre, g.nom
            FROM film f
            JOIN genre_film gf ON gf.id_film = f.id_film
            JOIN genre g ON g.id_genre = gf.id_genre
            ORDER BY note DESC, titre ASC
        ");

        // Requete pour récupérer les années
        $requeteAfficherAnnees = $pdo->query("
            SELECT DISTINCT YEAR(dateSortie) as year
            FROM film
        ");

        // Requete pour récupérer les infos des réalisateurs et l'id film
        $requeteAfficherFilmsRealisateurs = $pdo->query("
            SELECT f.id_film, r.id_realisateur, CONCAT(p.prenom, ' ', p.nom) as name
            FROM film f
            JOIN realisateur r ON r.id_realisateur = f.id_realisateur
            JOIN personne p ON p.id_personne = r.id_personne
        ");

        // Requete pour récupérer les infos des acteurs et l'id film
        $requeteAfficherFilmsActeurs = $pdo->query("
            SELECT c.id_film, a.id_acteur, CONCAT(p.prenom, ' ', p.nom) as name
            FROM casting c
            JOIN acteur a ON a.id_acteur = c.id_acteur
            JOIN personne p ON p.id_personne = a.id_personne
        ");

        // Requete pour récupérer les infos de la table genre
        $requeteAfficherGenres = $pdo->query("
            SELECT *
            FROM genre
            ORDER BY nom ASC
        ");

        // Requete pour récupérer la liste des films par genre
        $requeteAfficherFilmsGenre = $pdo->prepare("
            SELECT *, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, DATE_FORMAT(dateSortie, '%e %M %Y') as dateDeSortie, g.id_genre, g.nom
            FROM film f
            JOIN genre_film gf ON gf.id_film = f.id_film
            JOIN genre g ON g.id_genre = gf.id_genre
            WHERE g.id_genre = :id_genre
        ");
        $requeteAfficherFilmsGenre->execute([
            'id_genre' => $genreFiltre
        ]);

        // Requete pour récupérer la liste des films par année
        $requeteAfficherFilmsAnnee = $pdo->prepare("
            SELECT *, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat
            FROM film
            WHERE YEAR(dateSortie) = :year
        ");
        $requeteAfficherFilmsAnnee->execute([
            'year' => $yearFiltre
        ]);

        require "view/listFilms.php";

    }
    
}