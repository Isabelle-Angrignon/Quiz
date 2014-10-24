<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    redirigerSiNonConnecte('Admin');
    ?>
</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php



?>

<div class="contenu">

Page Admin

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>