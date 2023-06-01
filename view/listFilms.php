<?php

ob_start();

// Configuration
$filmsParPage = 10; // Nombre de films par page
$films = $requeteAfficherFilms->fetchAll();

$filmsAvecGenres = array();
while ($filmGenres = $requeteAfficherFilmsGenres->fetch()) {
  $idFilm = $filmGenres['id_film'];
  $idGenre = $filmGenres['id_genre'];
  $nomGenre = $filmGenres['nom'];

  if (!isset($filmsAvecGenres[$idFilm])) {
    $filmsAvecGenres[$idFilm] = array(
      'id_film' => $idFilm,
      'nomGenres' => array(),
      'idGenres' => array()
    );
  }
  $filmsAvecGenres[$idFilm]['nomGenres'][] = $nomGenre;
  $filmsAvecGenres[$idFilm]['idGenres'][] = $idGenre;
}

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
        <li>
          <img src="public/img/<?= $film['affiche']; ?>" alt="Affiche du film : <?= $film['id_film'] ?>">
          <div>
            <a href="index.php?action=detailsFilm&id=<?= $film['id_film'] ?>"><?= $film['titre'] ?></a>
            <div>
              <?= $film['dureeFormat']; ?> / 
                <?php
                $idFilm = $film['id_film'];
                if (isset($filmsAvecGenres[$idFilm])) {
                  $nomGenres = $filmsAvecGenres[$idFilm]['nomGenres'];
                  $genresListe = implode(', ', $nomGenres); // permet de concaténer les noms des genres avec une virgule
                  echo rtrim($genresListe, ', '); // permet de supprimer ", " à droite de la chaîne de caractère $genresListe (fonctionne comme trim mais avec r ou l pour le début ou la fin)
                }
                ?>
            </div>
            <div>
              De 
            </div>
          </div>
        </li>
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
