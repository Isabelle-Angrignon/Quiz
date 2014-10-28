<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    ?>
    <link rel="stylesheet" href="Vue/CSS/Developeur.css" type="text/css" media="screen" >
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

<div id="page" class="contenu">
    <h1>Les dévelopeurs</h1>
    <hr>
    <div class="conteneur">
        <div class="gauche">
            <img src="Vue/Images/Simon.jpg" id="ImgSimon">
            <img src="Vue/Images/Mathieu.jpg" id="ImgMathieu">
            <img src="Vue/Images/Isabelle.jpg" id="ImgIsa">

        </div>
        <div class="droite">
            <label class="DescSimon gras">Simon Bouchard</label>
            <label class="DescMathieu gras"> Mathieu Dumoulin</label>
            <label class="DescIsa gras">Isabelle Angrignon</label>
        </div>
        <div class="droite">
            <label class="DescSimon">simon.bouchard01@gmail.com</label>
            <label class="DescMathieu">Mathieu.Dumoulin@outlook.com</label>
            <label class="DescIsa">isabelle.angrignon@hotmail.ca</label>
        </div>
    </div>

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>