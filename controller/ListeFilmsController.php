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

        // Requete pour récupérer les infos du réalisateur
        $requeteAfficherRealisateurs = $pdo->query("
            SELECT id_realisateur, CONCAT(nom, ' ', prenom) as name
            FROM realisateur r
            JOIN personne p ON p.id_personne = r.id_personne
        ");

        // Requete pour récupérer les infos des acteurs
        $requeteAfficherActeurs = $pdo->query("
            SELECT id_acteur, CONCAT(nom, ' ', prenom) as name
            FROM acteur a
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
            SELECT f.id_film as idFilm, f.titre as titre, g.nom as nomGenre
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
            SELECT *
            FROM film
            WHERE YEAR(dateSortie) = :year
        ");
        $requeteAfficherFilmsAnnee->execute([
            'year' => $yearFiltre
        ]);

        require "view/listFilms.php";

    }
    
}