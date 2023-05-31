<?php

ob_start();

// Configuration
$filmsParPage = 10; // Nombre de films par page
$films = $requeteAfficherFilms->fetchAll();
$genres = $requeteAfficherGenres->fetchAll();
$years = $requeteAfficherAnnees->fetchAll();

// Filtre Genre et Annéee
// Récupérer le filtre de la page, genre ou année
$genreFiltre = isset($_GET['genre']) ? $_GET['genre'] : null;
$yearFiltre = isset($_GET['year']) ? $_GET['year'] : null;

if ($genreFiltre) {
  $filmsFiltres = $requeteAfficherFilmsGenre->fetchAll();
} elseif ($yearFiltre) {
  $filmsFiltres = $requeteAfficherFilmsAnnee->fetchAll();
} else {
  $filmsFiltres = $films;
}

// Pagination
$totalFilms = count($filmsFiltres);
$totalPages = ceil($totalFilms / $filmsParPage);

// Récupérer le numéro de la page courante depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Vérifier si la valeur de la page est valide
if ($page < 1 || $page > $totalPages) {
  $page = 1;
}

// Calculer l'indice de départ pour la sélection des films
$indiceDebut = ($page - 1) * $filmsParPage;
$indiceFin = $indiceDebut + $filmsParPage - 1;

// Sélectionner les films pour la page courante
$filmsPageCourante = array_slice($filmsFiltres, $indiceDebut, $filmsParPage);

?>

<section id="allFilms">
  <h1>Liste des Films</h1>

  <div class="filtres">
    <div class="header">
      <h3>Filtres</h3>
      <a href="index.php?action=listFilms">Reset</a>
    </div>
      <div class="dropdown-toggle">Par genres &#x25BC;</div>
      <ul class="dropdown-menu">
        <?php
        foreach ($genres as $genre) {
        ?>
          <li><a href="index.php?action=listFilms&genre=<?= $genre['id_genre'] ?>"><?= $genre['nom'] ?></a></li>
        <?php
        }
        ?>
      </ul>

      <div class="dropdown-toggle">Par années de production &#x25BC;</div>
      <ul class="dropdown-menu">
        <?php
        foreach ($years as $year) {
        ?>
          <li><a href="index.php?action=listFilms&year=<?= $year['year'] ?>"><?= $year['year'] ?></a></li>
        <?php
        }
        ?>
      </ul>
  </div>

  <div class="films">
    <ul>
      <?php
      foreach ($filmsPageCourante as $film) {
      ?>
        <li><a href="index.php?action=detailsFilm&id=<?= $film['id_film'] ?>"><?= $film['titre'] ?></a></li>
      <?php
      }
      ?>

    </ul>

    <div class="pagination">
      <?php
      // Générer les liens de pagination
      for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $page) ? 'active' : '';
        if ($genreFiltre) {
          echo "<a href=\"index.php?action=listFilms&genre=$genreFiltre&page=$i\" class=\"$activeClass\">$i</a>";
        } elseif ($yearFiltre) {
          echo "<a href=\"index.php?action=listFilms&year=$yearFiltre&page=$i\" class=\"$activeClass\">$i</a>";
        } else {
          echo "<a href=\"index.php?action=listFilms&page=$i\" class=\"$activeClass\">$i</a>";
        }
      }
      ?>
    </div>
  </div>
</section>

<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";
