<?php

ob_start();

?>

<section id="modifier-film">

</section>

<?php

$titre = "Modifier film : ";
$titre_secondaire = "Modification des films";
$contenu = ob_get_clean();
require "view/template.php";