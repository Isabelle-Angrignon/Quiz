<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    ?>
    <link rel="stylesheet" href="Vue/CSS/APropos.css" type="text/css" media="screen" >
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
    <div class = "centrer">
        <h1 id="header"> Le projet Quiz </h1>
        <img id="logo" src="Vue/Images/Logo_QIz.png" alt="logo" >
        <p class="centrer">
            Le QuizInfo est un outil de génération de quiz avec une base de données contenant
            entre autre une banque de questions de plusieurs types : des questions à choix de réponse,
            réponses multiples et questions à vrai ou faux.
        </p >
        <p class="centrer">
            Cet outil comporte plusieurs interfaces dont une pour les professeurs et les administrateurs
            et une autre pour les étudiants. Le QuizInfo pourrait particulièrement être utilisé pour permettre aux
            étudiants de première année de se pratiquer afin d’augmenter leur potentiel de réussite et réduire les abandons du programme.
            Les enseignants créent des questions et les agences en quiz à soumettre aux étudiants.
        </p>

    </div>

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>