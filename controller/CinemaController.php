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

        $requeteFilm = $pdo->prepare("
            SELECT affiche, titre, note, DATE_FORMAT(dateSortie, '%e %M %Y') as dateSortie, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%k H %i') AS dureeFormat, synopsis
            FROM film
            WHERE id_film = :id
        ");
        $requeteGenre = $pdo->prepare("
            SELECT *
            FROM genre g
            JOIN genre_film gf ON g.id_genre = gf.id_genre
            JOIN film f ON f.id_film = gf.id_film
            WHERE f.id_film = :id
        ");
        $requeteRealisateur = $pdo->prepare("
            SELECT CONCAT(p.nom, ' ', p.prenom) AS realisateur, r.id_realisateur AS idRealisateur
            FROM personne p
            JOIN realisateur r ON r.id_personne = p.id_personne
            JOIN film f ON f.id_realisateur = r.id_realisateur
            WHERE f.id_film = :id
        ");
        $requeteActeur = $pdo->prepare("
            SELECT c.id_acteur as idActeur, CONCAT(p.nom, ' ', p.prenom) as acteur, r.role as role
            FROM casting c
            JOIN role r ON r.id_role = c.id_role
            JOIN film f ON f.id_film = c.id_film
            JOIN acteur a ON a.id_acteur = c.id_acteur
            JOIN personne p ON a.id_personne = p.id_personne
            WHERE f.id_film = :id
        ");

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
            ORDER BY p.nom ASC
        ");
        $requeteActeur = $pdo->query("
            SELECT a.id_acteur as id_acteur, CONCAT(p.nom, ' ', p.prenom) as name
            FROM personne p
            JOIN acteur a ON a.id_personne = p.id_personne
            ORDER BY p.nom ASC
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
            $idGenres = filter_input(INPUT_POST, 'idGenre', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY); // FILTER_REQUIRE_ARRAY : on veut récupérer les valeurs sous forme de tableau (idGenre[])

            if (isset($_POST['genre'])) {
                $genres = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                if ($genres == false) {
                    $_SESSION['Message'] = "Le champ genre est incorrect !";
                    echo $_SESSION['Message'];
                    die();
                }
            }

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
                        if ( !empty($titre) && !empty($dateSortie) && !empty($duree) && !empty($synopsis) && !empty($note) && ( !empty($idGenres) || !empty($genres) ) ) {

                            // Si aucun champ réalisateur est rempli, affiche un message
                            if (empty($idRealisateur) && (empty($nom) && empty($prenom) && empty($sexe) && empty($dateNaiss))) {
                                var_dump("1er filtre rea");
                                die();
                                $_SESSION['Message'] = "Un réalisateur doit être sélectionné ou créé.";
                                header("Location: index.php?action=admin#modalAddFilm");

                                // Si un réalisateur existant a été choisit : utilise la requête avec un réalisateur existant (+check le filtre)
                            } elseif ( ( !empty($idRealisateur) && $idRealisateur !== false ) && (empty($nom) || empty($prenom) || empty($sexe) || empty($dateNaiss))) {
                                
                                // Requete pour ajouter un/des genre(s) à la db
                                $requeteAddNewGenre = $pdo->prepare("
                                    INSERT INTO genre (nom)
                                    VALUE (:genre)
                                ");
                                $requeteGetGenreId = $pdo->prepare("
                                    SELECT LAST_INSERT_ID() as genreId
                                ");
                                
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

                                // condition si un nouveau genre a été saisi
                                if (!empty($genres)) {
                                    // Execute la requête pour ajouter le ou les genre(s) et récupérer l'id
                                    foreach ($genres as $genre) {
                                        $requeteAddNewGenre->execute([
                                            'genre' => $genre
                                        ]);
                                        $requeteGetGenreId->execute();
    
                                        $requete = $requeteGetGenreId->fetch();
                                        $idNewGenres[] = $requete['genreId'];
                                    }
                                }
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
                                // Execute cette requête uniquement si un nouveau genre a été saisi
                                if (!empty($genres)) {
                                    foreach ($idNewGenres as $idGenre) {
                                        $requeteAddGenre->execute([
                                            'idGenre' => $idGenre
                                        ]);
                                    }
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


                                // Requete pour ajouter un/des genre(s) à la db
                                $requeteAddNewGenre = $pdo->prepare("
                                    INSERT INTO genre (nom)
                                    VALUE (:genre)
                                ");
                                $requeteGetGenreId = $pdo->prepare("
                                    SELECT LAST_INSERT_ID() as genreId
                                ");

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

                                // condition si un nouveau genre a été saisi
                                if (!empty($genres)) {
                                    // Execute la requête pour ajouter le ou les genre(s) et récupérer l'id
                                    foreach ($genres as $genre) {
                                        $requeteAddNewGenre->execute([
                                            'genre' => $genre
                                        ]);
                                        $requeteGetGenreId->execute();
    
                                        $requete = $requeteGetGenreId->fetch();
                                        $idNewGenres[] = $requete['genreId'];
                                    }
                                }

                                //Execute la requete pour ajouter une personne
                                $requeteAddPersonne->execute([
                                    'nom' => $nom,
                                    'prenom' => $prenom,
                                    'sexe' => $sexe,
                                    'dateNaissance' => $dateNaiss
                                ]);

                                //Execute la requete pour ajouter la personne à réalisateur
                                $requeteAddRealisateur->execute();

                                //Execute la requête pour ajouter un film
                                $requeteAddFilm->execute([
                                    'titre' => $titre,
                                    'dateSortie' => $dateSortie,
                                    'duree' => $duree,
                                    'synopsis' => $synopsis,
                                    'note' => $note,
                                    'affiche' => $affiche
                                ]);
                                //Execute la requete pour récupérer l'id du dernier film ajouté
                                $requeteLastIdFilm->execute();

                                //Execute la requête pour ajouter le ou les genres au film ajouté
                                if (!empty($idGenres)) {
                                    foreach ($idGenres as $idGenre) {
                                        $requeteAddGenre->execute([
                                            'idGenre' => $idGenre
                                        ]);
                                    }
                                }

                                // Execute cette requête uniquement si un nouveau genre a été saisi
                                if (!empty($genres)) {
                                    foreach ($idNewGenres as $idGenre) {
                                        $requeteAddGenre->execute([
                                            'idGenre' => $idGenre
                                        ]);
                                    }
                                }

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

            // Filtre Select acteur
            $idActeur = filter_input(INPUT_POST, 'idActeur', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
            $arrayRoles = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

            // Filtre Input acteur
            $noms = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $prenoms = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $sexes = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $datesNaiss = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $roles = filter_input(INPUT_POST, 'role2', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

            var_dump($noms); 

            if ($idActeur !== false && $arrayRoles !== false && $noms !== false && $prenoms !== false && $sexes !== false && $datesNaiss !== false && $roles !== false) {
                if ( ( !empty($idActeur) && !empty($arrayRoles) ) || ( !empty($noms) && !empty($prenoms) && !empty($sexes) && !empty($datesNaiss) && !empty($roles) ) ) {

                    // Requete pour le select (acteur + addRole + addCasting)
                    if ( !empty($idActeur) && !empty($arrayRoles) ) {
                        foreach ($arrayRoles as $i => $role) {
                            // requete pour ajouter un nouveau role
                            $requeteAddRole = $pdo->prepare("
                                INSERT INTO role (role)
                                VALUE (:role)
                            ");
                            // requete pour ajouter la partie select dans la table casting
                            $requeteAddCasting = $pdo->prepare("
                                INSERT INTO casting (id_film, id_acteur, id_role)
                                VALUE (:id_film, :id_acteur, LAST_INSERT_ID())
                            ");

                            // execute la requete pour ajouter un nouveau role
                            $requeteAddRole->execute([
                                'role' => $role
                            ]);
                            // execute la requete pour ajouter la partie select dans la table casting
                            $requeteAddCasting->execute([
                                'id_film' => $_SESSION['id'],
                                'id_acteur' => $idActeur[$i]
                            ]);
                        }
                    }

                    if ( !empty($noms) && !empty($prenoms) && !empty($sexes) && !empty($datesNaiss) && !empty($roles) ) {
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
                        // Requete pour ajouter un casting
                        $requeteAddCasting = $pdo->prepare("
                            INSERT INTO casting (id_film, id_acteur, id_role)
                            VALUE (:id_film, :id_acteur, :id_role)
                        ");

                        foreach($noms as $i => $nom) {
                            // Execute la requete pour créer une personne
                            $requeteAddPersonne->execute([
                                'nom' => $nom,
                                'prenom' => $prenoms[$i],
                                'sexe' => $sexes[$i],
                                'dateNaissance' => $datesNaiss[$i]
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
                                'role' => $roles[$i]
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
                        }
                    }

                    session_unset();
                    $_SESSION['Message'] = "Le casting a été ajouté.";
                    header("Location: index.php?action=admin");
                } else {
                    var_dump("Erreur input ajouter casting");
                    die();
                }

            } else {
                var_dump("Erreur filtre bool");
                die();
            }

        }

        

        // Supprimer un film

        if (isset($_POST['supprimerFilmSubmit'])) {

            $idFilm = $_GET['id'];

            //Requete pour récupérer le nom de l'image
            $requeteImage = $pdo->prepare("
                SELECT affiche
                FROM film
                WHERE id_film = :id_film
            ");

            //Execute la requete pour récupérer le nom de l'image
            $requeteImage->execute([
                "id_film" => $idFilm
            ]);
            
            $affiche = $requeteImage->fetch();
            $nomAffiche = $affiche['affiche'];
            // var_dump($nomAffiche);
            // die();
            unlink("public/img/" . $nomAffiche);

            // requete pour supprimer des castings
            $requeteSupprimerCasting = $pdo->prepare("
                DELETE FROM casting
                WHERE id_film = :id_film
            ");
        
            // requete pour supprimer le ou les genres associé à un film
            $requeteSupprimerGenreFilm = $pdo->prepare("
                DELETE FROM genre_film
                WHERE id_film = :id_film
            ");
        
            // requete pour supprimer un film avec l'id
            $requeteSupprimerFilm = $pdo->prepare("
                DELETE FROM film
                WHERE id_film = :id_film
            ");
        
            //Execute la requete pour supprimer des castings
            $requeteSupprimerCasting->execute([
                "id_film" => $idFilm
            ]);
        
            //Execute la requete pour supprimer les genres associés au film
            $requeteSupprimerGenreFilm->execute([
                "id_film" => $idFilm
            ]);
        
            //Execute la requete pour supprimer le film
            $requeteSupprimerFilm->execute([
                "id_film" => $idFilm
            ]);


            $_SESSION['Message'] = "Film supprimé";
            header("Location: index.php?action=admin");
        }

        require "view/admin.php";
    }

    /* Modifier les informations d'un film */
    public function modifierFilm($id)
    {

        $pdo = Connect::seConnecter();

        // Requête pour récupérer tous les réalisateurs
        $requeteRealisateur = $pdo->query("
            SELECT CONCAT(p.nom, ' ', p.prenom) AS realisateur, r.id_realisateur AS id_realisateur
            FROM personne p
            JOIN realisateur r ON r.id_personne = p.id_personne
            ORDER BY realisateur ASC
        ");
        // Requête pour récupérer tous les acteurs
        $requeteActeur = $pdo->query("
            SELECT CONCAT(p.nom, ' ', p.prenom) AS acteur, a.id_acteur AS id_acteur
            FROM personne p
            JOIN acteur a ON a.id_personne = p.id_personne
            ORDER BY acteur ASC
        ");
        // Requête pour récupérer tous les rôles
        $requeteRole = $pdo->query("
            SELECT *
            FROM role
            ORDER BY role ASC
        ");
        // Requête pour récupérer les infos de tous les castings
        $requeteCasting = $pdo->prepare("
            SELECT c.id_film, c.id_acteur, c.id_role, f.titre, CONCAT(p.nom, ' ', p.prenom) AS acteur, r.role
            FROM casting c
            JOIN film f ON f.id_film = c.id_film
            JOIN acteur a ON a.id_acteur = c.id_acteur
            JOIN personne p ON p.id_personne = a.id_personne
            JOIN role r ON r.id_role = c.id_role
            WHERE f.id_film = :id_film
        ");
        // Requête pour afficher les infos du film
        $requeteFilm = $pdo->prepare("
            SELECT *
            FROM film
            WHERE id_film = :id_film
        ");
        // Requûete pour récupérer tous les genres d'un film
        $requeteGenreFilm = $pdo->prepare("
            SELECT g.id_genre AS id_genre, g.nom AS nom
            FROM genre g
            JOIN genre_film gf ON gf.id_genre = g.id_genre
            JOIN film f ON f.id_film = gf.id_film
            WHERE f.id_film = :id_film
        ");
        // Requûete pour récupérer tous les genres
        $requeteGenres = $pdo->query("
            SELECT *
            FROM genre
            ORDER BY nom ASC
        ");

        // Execute les requêtes
        $requeteFilm->execute(['id_film' => $id]);
        $requeteGenreFilm->execute(['id_film' => $id]);
        $requeteCasting->execute(['id_film' => $id]);


        // Requete pour ajouter un genre
        if (isset($_POST['addGenreSubmit']) && isset($_GET['id'])) {
            $id = $_GET['id'];
            $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($genre !== false && !empty($genre)) {

                $pdo = Connect::seConnecter();

                $requeteAddGenre = $pdo->prepare("
                    INSERT INTO genre (nom)
                    VALUE (:nom)
                ");
                $requeteAddGenre->execute([
                    'nom' => $genre
                ]);

                $_SESSION['message'] = "Le genre $genre a été ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
            else {
                $_SESSION['message'] = "Erreur : Le champ n'a pas pu être ajouté";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
        }

        // Requete pour ajouter un realisateur
        if (isset($_POST['addRealisateurSubmit']) && isset($_GET['id'])) {
            $id = $_GET['id'];
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaiss = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($nom !== false && $prenom !== false && $sexe !== false && $dateNaiss !== false && !empty($nom) && !empty($prenom) && !empty($sexe) && !empty($dateNaiss)) {

                $pdo = Connect::seConnecter();

                $requeteAddPersonne = $pdo->prepare("
                    INSERT INTO personne (nom, prenom, sexe, dateNaissance)
                    VALUE (:nom, :prenom, :sexe, :dateNaissance)
                ");
                $requeteAddRealisateur = $pdo->prepare("
                    INSERT INTO realisateur (id_personne)
                    SELECT LAST_INSERT_ID()
                ");
                $requeteAddPersonne->execute([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'sexe' => $sexe,
                    'dateNaissance' => $dateNaiss
                ]);
                $requeteAddRealisateur->execute();

                $_SESSION['message'] = "Le réalisateur $nom $prenom a été ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
            else {
                $_SESSION['message'] = "Erreur : Le réalisateur n'a pas pu être ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
        }

        // Requete pour ajouter un acteur
        if (isset($_POST['addActeurSubmit']) && isset($_GET['id'])) {
            $id = $_GET['id'];
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaiss = filter_input(INPUT_POST, 'dateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($nom !== false && $prenom !== false && $sexe !== false && $dateNaiss !== false && !empty($nom) && !empty($prenom) && !empty($sexe) && !empty($dateNaiss)) {

                $pdo = Connect::seConnecter();

                $requeteAddPersonne = $pdo->prepare("
                    INSERT INTO personne (nom, prenom, sexe, dateNaissance)
                    VALUE (:nom, :prenom, :sexe, :dateNaissance)
                ");
                $requeteAddActeur = $pdo->prepare("
                    INSERT INTO acteur (id_personne)
                    SELECT LAST_INSERT_ID()
                ");
                $requeteAddPersonne->execute([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'sexe' => $sexe,
                    'dateNaissance' => $dateNaiss
                ]);
                $requeteAddActeur->execute();

                $_SESSION['message'] = "L'acteur $nom $prenom a été ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
            else {
                $_SESSION['message'] = "Erreur : L'acteur n'a pas pu être ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
        }

        // Requete pour ajouter un rôle
        if (isset($_POST['addRoleSubmit']) && isset($_GET['id'])) {
            $id = $_GET['id'];
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($role !== false && !empty($role)) {

                $pdo = Connect::seConnecter();

                $requeteAddGenre = $pdo->prepare("
                    INSERT INTO role (role)
                    VALUE (:role)
                ");
                $requeteAddGenre->execute([
                    'role' => $role
                ]);

                $_SESSION['message'] = "Le rôle $genre a été ajouté.";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
            else {
                $_SESSION['message'] = "Erreur : Le rôle n'a pas pu être ajouté";
                header("Location: index.php?action=modifierFilm&id=$id");
            }
        }

        require "view/modifierFilm.php";
    }

}
