


<?php
include("Vue/Template/InclusionTemplate.php");
include("Modele/mFonctionsQuizEtudiant.php");
include("Controleur/cFonctionsQuizEtudiant.php");
include("Modele/ModeleQuestions.php");
demarrerSession();
redirigerSiNonConnecte();

$cours = $_SESSION['idCours'];

if($cours == '0')
{
    echo '<script>alert ("Choisir un cours")</script>';
}

//devra fair un switch case selon le type de quiz...
$Liste = genererQuestionsAleatoires($cours);

if (isset($Liste) && !empty($Liste))
{
    shuffle($Liste);// ne pas réassigner a un array, les éléments sont mélengés à même la variable.

    $_SESSION["listeQuestions"] = $Liste;
    //Preparer premiere question
    $idQuestion = $_SESSION['listeQuestions'][0];
    //recupérer infos question
    $_SESSION['infoQuestion'] = recupererElementsQuestion($idQuestion['idQuestion']);
    array_shift($_SESSION['listeQuestions']);
}





?>


