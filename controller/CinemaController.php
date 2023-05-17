<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class CinemaController
{

    /* Lister les films */
    public function listFilms()
    {

        $pdo = Connect::seConnecter();
        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");
        $requeteFilms = $pdo->query("
            SELECT id_film, affiche, duree, titre, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, DATE_FORMAT(dateSortie, '%e %M %Y') as dateSortie, titre as test
            FROM film
        ");

        require "view/accueil.php";
    }

    /* Détails des films */
    public function detailsFilm($id)
    {

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
        $requeteRealisateur = $pdo->prepare("
            SELECT CONCAT(nom, ' ', prenom) as rea
            FROM personne p
            JOIN realisateur r ON r.id_personne = p.id_personne
            JOIN film f ON f.id_realisateur = r.id_realisateur
            WHERE f.id_film = :id
        ");
        $requeteActeur = $pdo->prepare("
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
    public function addFilm()
    {

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
            $idRealisateur = filter_input(INPUT_POST, 'idRealisateur', FILTER_VALIDATE_INT);
            $idGenres = filter_input(INPUT_POST, 'idGenre', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY); // FILTER_REQUIRE_ARRAY : on veut récupérer les valuers sous forme de tableau (idGenre[])

            //Filtre pour ajouter un nouveau réalisateur
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaiss = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Vérifie si une image a été mise
            if (isset($_FILES['affiche'])) {

                $tmpName = $_FILES['affiche']['tmp_name'];
                $ImgName = $_FILES['affiche']['name'];
                $size = $_FILES['affiche']['size'];
                $error = $_FILES['affiche']['error'];

                // vérification sur l'extension du fichier //
                $tabExtension = explode('.', $ImgName);
                $extension = strtolower(end($tabExtension));
                //Tableau des extensions que l'on accepte
                $extensions = ['jpg', 'png', 'jpeg'];
                //Taille max que l'on accepte
                $maxSize = 4000000;

                // Vérifie si c'est bien une image avec les bonnes caractéristiques
                if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
                    $uniqueName = uniqid('', true);
                    //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                    $affiche = $uniqueName . "." . $extension;
                    //$affiche = 5f586bf96dcd38.73540086.jpg
                    move_uploaded_file($tmpName, 'public\img/' . $affiche);

                    //check les filtres
                    if ( $titre !== false && $dateSortie !== false && $duree !== false && $synopsis !== false && $note !== false && $idGenres !== false ) {

                        //Vérifie si les champs ne sont pas vide (sauf pour la partie réalisateur)
                        if ( !empty($titre) && !empty($dateSortie) && !empty($duree) && !empty($synopsis) && !empty($note) && !empty($idGenres) ) {

                            // Si aucun champ réalisateur est rempli, affiche un message
                            if (empty($idRealisateur) && (empty($nom) && empty($prenom) && empty($sexe) && empty($dateNaiss))) {
                                var_dump("1er filtre rea");
                                die();
                                $_SESSION['Message'] = "Un réalisateur doit être sélectionné ou créé.";
                                header("Location: index.php?action=admin#modalAddFilm");

                                // Si un réalisateur existant a été choisit : utilise la requête avec un réalisateur existant (+check le filtre)
                            } elseif ( ( !empty($idRealisateur) && $idRealisateur !== false ) && (empty($nom) || empty($prenom) || empty($sexe) || empty($dateNaiss))) {
                                // Requete pour ajouter un film à la DB
                                $requeteAddFilm = $pdo->prepare("
                                    INSERT INTO film (titre, dateSortie, duree, synopsis, note, affiche, id_realisateur)
                                    VALUES (:titre, :dateSortie, :duree, :synopsis, :note, :affiche, :idRealisateur)
                                ");
                                // Requete pour ajouter un ou plusieurs genre au film ajouté
                                $requeteAddGenre = $pdo->prepare("
                                    INSERT INTO genre_film (id_film, id_genre)
                                    SELECT LAST_INSERT_ID(), :idGenre
                                ");
                                //Requete pour récupérer l'id du film ajouté
                                $requeteLastIdFilm = $pdo->query("
                                    SELECT LAST_INSERT_ID() as lastId, titre
                                    FROM film
                                    WHERE id_film = LAST_INSERT_ID()
                                ");

                                //Execute la requête pour ajouter un film
                                $requeteAddFilm->execute([
                                    'titre' => $titre,
                                    'dateSortie' => $dateSortie,
                                    'duree' => $duree,
                                    'synopsis' => $synopsis,
                                    'note' => $note,
                                    'affiche' => $affiche,
                                    'idRealisateur' => $idRealisateur
                                ]);
                                //Execute la requête pour ajouter le ou les genres au film ajouté
                                foreach ($idGenres as $idGenre) {
                                    $requeteAddGenre->execute([
                                        'idGenre' => $idGenre
                                    ]);
                                }
                                //Execute la requete pour récupérer l'id du dernier film ajouté
                                $requeteLastIdFilm->execute();

                                //Id du dernier film en session
                                $lastFilm = $requeteLastIdFilm->fetch();
                                $_SESSION['id'] = $lastFilm['lastId'];
                                $_SESSION['titre'] = $lastFilm['titre'];

                                // Redirection sur le modal après l'ajout du film
                                $_SESSION['Message'] = "Film ajouté.";
                                header("Location: index.php?action=admin#modalAddCasting");

                            } elseif ( (!empty($nom) && !empty($prenom) && !empty($sexe) && !empty($dateNaiss)) & ( $nom !== false && $prenom !== false && $sexe !== false && $dateNaiss!== false ) ) { // Si l'utilisateur veut créer un nouveau réalisateur

                                // Requete pour créer une personne
                                $requeteAddPersonne = $pdo->prepare("
                                    INSERT INTO personne (nom, prenom, sexe, dateNaissance)
                                    VALUE (:nom, :prenom, :sexe, :dateNaissance)
                                ");

                                // Requete pour que cette personne soit un rélisateur
                                $requeteAddRealisateur = $pdo->prepare("
                                    INSERT INTO realisateur (id_personne)
                                    SELECT LAST_INSERT_ID()
                                ");

                                // Requete pour ajouter un film à la DB
                                $requeteAddFilm = $pdo->prepare("
                                    INSERT INTO film (titre, dateSortie, duree, synopsis, note, affiche, id_realisateur)
                                    VALUES (:titre, :dateSortie, :duree, :synopsis, :note, :affiche, LAST_INSERT_ID())
                                ");
                                // Requete pour ajouter un ou plusieurs genre au film ajouté
                                $requeteAddGenre = $pdo->prepare("
                                    INSERT INTO genre_film (id_film, id_genre)
                                    SELECT LAST_INSERT_ID(), :idGenre
                                ");

                                //Requete pour récupérer l'id du film ajouté
                                $requeteLastIdFilm = $pdo->query("
                                    SELECT LAST_INSERT_ID() as lastId, titre
                                    FROM film
                                    WHERE id_film = LAST_INSERT_ID()
                                ");

                                //Execute la requete pour ajouter une personne
                                $requeteAddPersonne->execute([
                                    'nom' => $nom,
                                    'prenom' => $prenom,
                                    'sexe' => $sexe,
                                    'dateNaissance' => $dateNaiss
                                ]);

                                //Execute la requete pour ajouter la personne à réalisateur
                                $requeteAddRealisateur->execute();

                                //Execute la requête pour ajouter una film
                                $requeteAddFilm->execute([
                                    'titre' => $titre,
                                    'dateSortie' => $dateSortie,
                                    'duree' => $duree,
                                    'synopsis' => $synopsis,
                                    'note' => $note,
                                    'affiche' => $affiche
                                ]);

                                //Execute la requête pour ajouter le ou les genres au film ajouté
                                foreach ($idGenres as $idGenre) {
                                    $requeteAddGenre->execute([
                                        'idGenre' => $idGenre
                                    ]);
                                }

                                //Execute la requete pour récupérer l'id du dernier film ajouté
                                $requeteLastIdFilm->execute();

                                //Id du dernier film en session
                                $lastFilm = $requeteLastIdFilm->fetch();
                                $_SESSION['id'] = $lastFilm['lastId'];
                                $_SESSION['titre'] = $lastFilm['titre'];

                                // Redirection sur le modal après l'ajout du film
                                $_SESSION['Message'] = "Nouveau réalisateur créé et film ajouté.";
                                header("Location: index.php?action=admin#modalAddCasting");
                            }

                            // Affiche un message si un des champs du film est vide    
                        } else {
                            var_dump("champs film erreur");
                            die();
                            $_SESSION['Message'] = "Tous les champs sont obligatoires.";
                            header("Location: index.php?action=admin#modalAddFilm");
                        }
                        // Si les filtres pour le film ne passe pas
                    } else {
                        var_dump("erreur filtre bool");
                        die();
                    }
                    // Si les caractéristiques de l'image ne correspondent pas
                } else {
                    var_dump("Caractéristiques image incorrect");
                    die();
                }
                // Else pour le champ image
            } else {
                var_dump("Image obligatoire");
                die();
            }
        }

        // Requete pour ajouter un casting
        if (isset($_POST['castingSubmit'])) {

            // Filtre
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //+FILTER_REQUIRE_ARRAY
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaiss = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            // Requete pour créer une personne
            $requeteAddPersonne = $pdo->prepare("
            INSERT INTO personne (nom, prenom, sexe, dateNaissance)
                VALUE (:nom, :prenom, :sexe, :dateNaissance)
            ");
            // Requete pour que cette personne soit un acteur
            $requeteAddActeur = $pdo->prepare("
                INSERT INTO acteur (id_personne)
                SELECT LAST_INSERT_ID()
            ");
            // Requete pour récupérer l'ID de l'acteur ajouté
            $requeteLastActeur = $pdo->query("
                SELECT LAST_INSERT_ID() as lastActorId
            ");
            // Requete pour ajouter un role
            $requeteAddRole = $pdo->prepare("
                INSERT INTO role (role)
                VALUE (:role)
            ");
            // Requete pour récupérer l'ID du role ajouté
            $requeteLastRole = $pdo->query("
                SELECT LAST_INSERT_ID() as lastRoleId
            ");
            $requeteAddCasting = $pdo->prepare("
                INSERT INTO casting (id_film, id_acteur, id_role)
                VALUE (:id_film, :id_acteur, :id_role)
            ");

            // Execute la requete pour créer une personne
            $requeteAddPersonne->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'dateNaissance' => $dateNaiss
            ]);
            // Execute la requete pour ajouter à la personne en tant qu'acteur
            $requeteAddActeur->execute();

            // Execute la requete pour récupérer l'ID de l'acteur ajouté
            $requeteLastActeur->execute();
            // Enregistrement de l'ID
            $requete = $requeteLastActeur->fetch();
            $idActeur = $requete['lastActorId'];

            // Execute la requete pour ajouter un role
            $requeteAddRole->execute([
                'role' => $role
            ]);

            // Execute la requete pour récupérer l'ID du role ajouté
            $requeteLastRole->execute();
            // Enregistrement 
            $requete = $requeteLastRole->fetch();
            $idRole = $requete['lastRoleId'];

            // Execute la requete pour ajouter un nouveau casting
            $requeteAddCasting->execute([
                "id_film" => $_SESSION['id'],
                "id_acteur" => $idActeur,
                "id_role" => $idRole
            ]);

            session_unset();
            $_SESSION['Message'] = "Le casting a été ajouté.";
            header("Location: index.php?action=admin");
        }

        require "view/admin.php";

    }
}
