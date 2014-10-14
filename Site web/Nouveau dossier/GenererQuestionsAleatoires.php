<!DOCTYPE html>
<html>

<?php
include("Vue/Template/InclusionTemplate.php");
include("Modele/mFonctionsQuizEtudiant.php");
include("Controleur/cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte();

$cours = $_SESSION['idCours'];

//devra fair un switch case selon le type de quiz...
$Liste = genererQuestionsAleatoires($cours);

if($cours == '0')
{
    echo '<script>alert ("Choisir un cours")</script>';
}

shuffle($Liste);// ne pas réassigner a un array, les éléments sont mélengés à même la variable.

$_SESSION["listeQuestions"] = $Liste;

header('Location: Etudiant-Accueil.php');
?>

</html>
