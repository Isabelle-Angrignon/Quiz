<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionTemplate.php");
    include("Vue/Template/InclusionJQuery.php");

    demarrerSession();
    ?>
</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
if(isset($_SESSION['typeUsager']))
{
    if($_SESSION['typeUsager'] == 'Prof' ||$_SESSION['typeUsager'] == 'Admin')
    {
        include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
    }
    else
    {
        include("Vue/Template/MenuEtudiant.php");
    }
}

?>

<div class="contenu">

FAQ

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>