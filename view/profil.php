<?php

// Vérification de la session utilisateur ou redirection
if (!isset($_SESSION['users'])) {
    $_SESSION['messageError'] = "Veuillez vous connecter pour accéder à votre profil.";
    header("Location: index.php?action=login");
    exit;
}

// Récupération des informations de l'utilisateur
$user = $_SESSION['users'];

ob_start();

?>

<section id="profil-container">
    <div id="profil">
        <h2>Bienvenue, <?php echo $user['username']; ?> !</h2>
        <div class="profile-info">
            <p><strong>Nom d'utilisateur:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <!-- Ajoutez d'autres informations de profil ici -->
        </div>
        <div class="button-container">
            <a href="index.php?action=delete-account" class="delete-button">Supprimer mon compte</a>
        </div>
    </div>
</section>

<?php

$titre = "Profil";
$titre_secondaire = "Mon profil";
$contenu = ob_get_clean();
require "view/template.php";
