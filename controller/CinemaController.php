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

    /* Ajouter un film */
    public function addFilm() {

        $pdo = Connect::seConnecter();

        $requeteTitres = $pdo->query("
            SELECT id_film, titre
            FROM film
        ");
        $requeteGenre = $pdo->query("
            SELECT *
            FROM genre
        ");
        $requeteRealisateur = $pdo->query("
            SELECT r.id_realisateur as id_realisateur, CONCAT(p.nom, ' ', p.prenom) as name
            FROM personne p
            JOIN realisateur r ON r.id_personne = p.id_personne
        ");

        // Requete ajouter un film

        if (isset($_POST['filmSubmit'])) {

            //Filtre
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // empèche injection de SQL ou de HTML, supprime toutes les balises
            $dateSortie = filter_input(INPUT_POST, 'dateSortie', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $duree = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $note = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //FILTER_VALIDATE_FLOAT (champ "price") : validera le prix que s'il est un nombre à virgule (pas de texte ou autre…), le drapeau FILTER_FLAG_ALLOW_FRACTION est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
            $affiche = filter_input(INPUT_POST, 'affiche', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idRealisateur = filter_input(INPUT_POST, 'idRealisateur', FILTER_VALIDATE_INT);
            $idGenres = filter_input(INPUT_POST, 'idGenre', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY); // FILTER_REQUIRE_ARRAY : on veut récupérer les valuers sous forme de tableau (idGenre[])

            //check les filtres
            if($titre !==false && $dateSortie !==false && $duree !==false && $synopsis !==false && $note !==false && $affiche !==false && $idRealisateur !==false && $idGenres !==false) {
            
            // Requete pour ajouter un film à la DB
            $requeteAddFilm = $pdo->prepare("
                INSERT INTO film (titre, dateSortie, duree, synopsis, note, affiche, id_realisateur)
                VALUES (:titre, :dateSortie, :duree, :synopsis, :note, :affiche, :idRealisateur)
            ");
            // Requete pour ajouter un ou plusieurs genre au film ajouté
            $requeteAddGenre = $pdo->prepare("
                INSERT INTO genre_film (id_film, id_genre)
                SELECT LAST_INSERT_ID(), :idGenre;
            ");

            $requeteAddFilm->execute([
                                    'titre' => $titre,
                                    'dateSortie' => $dateSortie,
                                    'duree' => $duree,
                                    'synopsis' => $synopsis,
                                    'note' => $note,
                                    'affiche' => $affiche,
                                    'idRealisateur' => $idRealisateur
            ]);
            foreach($idGenres as $idGenre) {
                                    $requeteAddGenre->execute([
                                        'idGenre' => $idGenre
                                    ]);
            }

            // Tentative de redirection sur le modal après l'ajout du film
            // if ($requeteAddFilm) {
                // header("Location: index.php?action=admin"); 
                // exit; // à check l'utilité
            // }

            }
        }
        require "view/admin.php";
    }
}