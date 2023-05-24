<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class RealisateurController
{

    /* Lister les réalisateurs */
    public function listRealisateurs($id)
    {
        $pdo = Connect::seConnecter();

        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");

        // Requete pour afficher les info de l'acteur depuis l'id
        $requeteAfficherRealisateur = $pdo->prepare("
        SELECT CONCAT(p.nom, ' ', P.prenom) AS realisateur, sexe, DATE_FORMAT(dateNaissance, '%e %M %Y') as dateNaiss
        FROM personne p
        JOIN realisateur r ON r.id_personne = p.id_personne
        WHERE r.id_realisateur = :id_realisateur
        ");
        
        // Execute la requete pour afficher les info de l'acteur
        $requeteAfficherRealisateur->execute([
            'id_realisateur' => $id
        ]);

        require "view/detailsRealisateur.php";
    }

}