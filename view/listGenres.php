<?php 

ob_start();

?>

<section id="list-genre">

</section>

<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";