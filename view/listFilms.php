<?php

ob_start();

// Configuration
$filmsParPage = 10; // Nombre de films par page
$films = $requeteAfficherFilms->fetchAll();
$genres = $requeteAfficherGenres->fetchAll();
$years = $requeteAfficherAnnees->fetchAll();
$filmsAvecGenres = array();
$filmsAvecRealisateurs = array();
$filmsAvecActeurs = array();

while ($filmGenres = $requeteAfficherFilmsGenres->fetch()) {
  $idFilm = $filmGenres['id_film'];
  $idGenre = $filmGenres['id_genre'];
  $nomGenre = $filmGenres['nom'];

  if (!isset($filmsAvecGenres[$idFilm])) {
    $filmsAvecGenres[$idFilm] = array(
      'id_film' => $idFilm,
      'nom_genres' => array(),
      'id_genres' => array()
    );
  }
  $filmsAvecGenres[$idFilm]['nom_genres'][] = $nomGenre;
  $filmsAvecGenres[$idFilm]['id_genres'][] = $idGenre;
}

while ($filmRealisateur = $requeteAfficherFilmsRealisateurs->fetch()) {
  $idFilm = $filmRealisateur['id_film'];
  $idRealisateur = $filmRealisateur['id_realisateur'];
  $nomRealisateur = $filmRealisateur['name'];

  if (!isset($filmsAvecRealisateur[$idFilm])) {
    $filmsAvecRealisateur[$idFilm] = array(
      'id_film' => $idFilm,
      'id_realisateur' => array(),
      'name' => array()
    );
  }
  $filmsAvecRealisateur[$idFilm]['id_realisateur'][] = $idRealisateur;
  $filmsAvecRealisateur[$idFilm]['name'][] = $nomRealisateur;
}

while ($filmActeurs = $requeteAfficherFilmsActeurs->fetch()) {
  $idFilm = $filmActeurs['id_film'];
  $idActeurs = $filmActeurs['id_acteur'];
  $nomActeurs = $filmActeurs['name'];

  if (!isset($filmsAvecActeurs[$idFilm])) {
    $filmsAvecActeurs[$idFilm] = array(
      'id_film' => $idFilm,
      'id_acteur' => array(),
      'name' => array()
    );
  }
  $filmsAvecActeurs[$idFilm]['id_acteur'][] = $idActeurs;
  $filmsAvecActeurs[$idFilm]['name'][] = $nomActeurs;
}

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
  <div class="main">
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
            <div class="description">
              <a href="index.php?action=detailsFilm&id=<?= $film['id_film'] ?>"><?= $film['titre'] ?></a>
              <div>
                <?= $film['dureeFormat'] ?> /
                <?php
                $idFilm = $film['id_film'];
                if (isset($filmsAvecGenres[$idFilm])) {
                  $genres = $filmsAvecGenres[$idFilm]['nom_genres'];
                  $idGenres = $filmsAvecGenres[$idFilm]['id_genres'];
                  $genresListe = array();
                  foreach ($genres as $index => $genre) {
                    $idGenre = $idGenres[$index];
                    $genresListe[] = '<a href="index.php?action=listFilms&genre=' . $idGenre . '">' . $genre . '</a>';
                  }
                  $afficherGenres = implode(', ', $genresListe);
                  echo rtrim($afficherGenres, ', ');
                }
                ?>
              </div>
              <div>
                De
                <?php
                if (isset($filmsAvecRealisateur[$idFilm])) {
                  $nomRealisateur = $filmsAvecRealisateur[$idFilm]['name'];
                  $idRealisateur = $filmsAvecRealisateur[$idFilm]['id_realisateur'];
                  $realisateursListe = implode($nomRealisateur);
                  $idRealisateursListe = implode($idRealisateur);
                ?>
                  <a href="index.php?action=detailsRealisateur&id=<?= $idRealisateursListe ?>"><?= $realisateursListe ?></a>
                <?php
                }
                ?>
              </div>
              <div>
                Avec
                <?php
                if (isset($filmsAvecActeurs[$idFilm])) {
                  $acteurs = $filmsAvecActeurs[$idFilm]['name'];
                  $idActeurs = $filmsAvecActeurs[$idFilm]['id_acteur'];
                  $acteursListe = array();
                  foreach ($acteurs as $index => $acteur) {
                    $idActeur = $idActeurs[$index];
                    $acteursListe[] = '<a href="index.php?action=detailsActeur&id=' . $idActeur . '">' . $acteur . '</a>';
                  }
                  $afficherActeurs = implode(', ', $acteursListe);
                  echo rtrim($afficherActeurs, ', ');
                }
                ?>
              </div>
              <div>
                <?php
                $synopsis = $film['synopsis'];
                if (strlen($synopsis > 300)) {
                  $synopsis = substr($synopsis, 0, 300) . "[...]";
                }
                echo $synopsis;
                ?>
              </div>
              <div class="note">
                <?php
                // Cette partie en PHP permet d'afficher la note du film sous forme d'étoile(s)
                $note = $film['note'];
                $nbEtoile = floor($film['note']); // Note entier inférieur
                $demiEtoile = ($note - $nbEtoile >= 0.2 && $note - $nbEtoile <= 0.8); // Booléen (0.2 <= note <= 0.8)
                $etoileSupp = ($note - $nbEtoile > 0.8); // Booléen (décimale note > 0.8)

                for ($i = 1; $i <= $note; $i++) {
                ?>
                  <i class="fa-sharp fa-solid fa-star"></i> <!-- Etoile complète -->
                <?php
                }

                if ($demiEtoile) {
                ?>
                  <i class="fa-regular fa-star-half-stroke"></i> <!-- Demi étoile -->
                <?php
                }

                if ($etoileSupp) {
                ?>
                  <i class="fa-sharp fa-solid fa-star"></i> <!-- Etoile complète supplémentaire -->
                <?php
                }

                $nbEtoileVide = 5 - $nbEtoile - ($demiEtoile ? 1 : 0) - ($etoileSupp ? 1 : 0); // calcul le nombre d'étoile vide nécessaire pour compléter la note sur 5 étoiles

                for ($i = 1; $i <= $nbEtoileVide; $i++) {
                ?>
                  <i class="fa-sharp fa-regular fa-star"></i> <!-- Etoile(s) vide(s) si nécessaire -->
                <?php
                }
                ?>

                (<?= $film['note']; ?>)
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
  </div>
</section>

<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";
