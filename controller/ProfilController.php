<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ProfilController
{
    /* Profil */
    public function profil()
    {
        require "view/profil.php";
    }

    /* Supprimer un compte */
    public function deleteAcc()
    {
        if (!isset($_SESSION['users']) || $_SESSION['users']['admin']) {
            $_SESSION['messageError'] = "Action non disponible";
            header("Location: index.php?action=accueil");
        }
            if ($_GET['action'] === 'delete-account') {
            $pdo = Connect::seConnecter();

            $requeteDeleteAcc = $pdo->prepare("
                DELETE FROM users
                WHERE id = :id
            ");
            $requeteDeleteAcc->execute([
                'id' => $_SESSION['users']['id']
            ]);
    
            unset($_SESSION['users']);
            $_SESSION['message'] = "Le compte a été supprimé";
            header("Location: index.php?action=accueil");
            exit;

        }

        require "view/profil.php";

    }
}