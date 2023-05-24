<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ActeurController
{
    /* Lister les acteurs */
    public function detailsActeur($id)
    {
        $pdo = Connect::seConnecter();

        $requeteLangue = $pdo->query("SET lc_time_names = 'fr_FR';");

        // Requete pour afficher les info de l'acteur depuis l'id
        $requeteAfficherActeur = $pdo->prepare("
        SELECT CONCAT(p.nom, ' ', P.prenom) AS acteur, sexe, DATE_FORMAT(dateNaissance, '%e %M %Y') as dateNaiss
        FROM personne p
        JOIN acteur a ON a.id_personne = p.id_personne
        WHERE a.id_acteur = :id_acteur
        ");
        
        // Execute la requete pour afficher les info de l'acteur
        $requeteAfficherActeur->execute([
            'id_acteur' => $id
        ]);

        require "view/detailsActeur.php";

    }
}