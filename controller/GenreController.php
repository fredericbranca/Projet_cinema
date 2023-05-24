<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class GenreController
{
    /* Lister les acteurs */
    public function listGenres()
    {
        $pdo = Connect::seConnecter();

        require "view/listGenres.php";

    }
}