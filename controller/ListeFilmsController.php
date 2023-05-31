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
            SELECT *
            FROM film
            ORDER BY note DESC, titre ASC
        ");

        // Requete pour récupérer les années
        $requeteAfficherAnnees = $pdo->query("
            SELECT DISTINCT YEAR(dateSortie) as year
            FROM film
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