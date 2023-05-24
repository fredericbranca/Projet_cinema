<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class GenreController
{
    /* Lister les acteurs */
    public function listGenres()
    {
        $pdo = Connect::seConnecter();

        // Requete pour récupérer les infos de la table genre
        $requeteAfficherGenres = $pdo->query("
            SELECT *
            FROM genre
        ");

        require "view/listGenres.php";

    }

    /* Liste des films par genre */
    public function listFilmsGenre($id)
    {
        $pdo = Connect::seConnecter();

        // Requete pour récupérer le nom du genre
        $requeteGenre = $pdo->prepare("
        SELECT *
        FROM genre
        WHERE id_genre = :id_genre
        ");

        // Requete pour récupérer la liste des films par genre
        $requeteAfficherFilmsGenre = $pdo->prepare("
            SELECT f.id_film as idFilm, f.titre as titre, g.nom as nomGenre
            FROM film f
            JOIN genre_film gf ON gf.id_film = f.id_film
            JOIN genre g ON g.id_genre = gf.id_genre
            WHERE g.id_genre = :id_genre
        ");

        // Execute les requetes
        $requeteAfficherFilmsGenre->execute(['id_genre' => $id]);
        $requeteGenre->execute(['id_genre' => $id]);

        require "view/listFilmsGenre.php";
    }

    
}