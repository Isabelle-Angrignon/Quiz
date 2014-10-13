<?php
session_start();
?>

<!DOCTYPE html>
<html>

<?php
include("Vue/Template/InclusionTemplate.php");
include("Modele/mFonctionsQuizEtudiant.php");
include("Controleur/cFonctionsQuizEtudiant.php");
redirigerSiNonConnecte();



$cours = $_SESSION['idCours'];

//devra fair un switch case selon le type de quiz...
$Liste = genererQuestionsAleatoires($cours);



echo ' variable   ' . print_r($Liste) . ' ordre de présentation non respectée </br>';
echo ' </br>';
foreach ($Liste as $quest)
{
    echo $quest['idQuestion'];
    echo ' </br>';
}
shuffle($Liste);// ne pas réassigner a un array, les éléments sont mélengés à même la variable.

echo ' </br>Apres mélange: </br>';
foreach ($Liste as $quest2)
{
    echo $quest2['idQuestion'];
    echo ' </br>';
}

$_SESSION["listeQuestions"] = $Liste;

/*
$test = $_SESSION["listeQuestions"];

echo ' </br></br> </br> test 2  ';

echo ' coockie   ' . print_r($test) . ' pis? ';


echo ' </br></br> </br>  $_COOKIE ';
foreach ($_SESSION['listeQuestions'] as $question)
{
    echo $question['idQuestion'];
    echo ' </br>';
}*/

//echo print_r( $_SESSION['listeQuestions']);

header('Location: Etudiant-Accueil.php');
?>

</html>
