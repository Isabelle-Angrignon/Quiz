<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AJAX_ModifierQuestion
//  Par: Mathieu Dumoulin
//  Date: 15/10/2014
//
//  Description :
//  Ce fichier effectue le contrôle entre la BD et la vue en ce qui à
//  trait de la modification d'une question à l'aide d'AJAX
//
////////////////////////////////////////////////////////////////////////////////////////////////////

//TODO devrait penser a indiquer les parametre post que le fichier prend
$doitArreter = false;
$question = $_POST['tableauQuestion'];
session_start();

if($question['enonceQuestion'] == "")
{
    echo "Vous devez entrer un énoncé à votre question.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauReponses']))
{
    echo "Modification de la question ne s'est pas fait car elle doit contenir au moins une réponse.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauCours']))
{
    echo "Vous devez associer votre question à au moins un cours.   ";
    $doitArreter = true;
}
if(!isset($_POST['typeQuestion']))
{
    echo "Vous devez lier la question à un type de question.   ";
    $doitArreter = true;
}


if($doitArreter)
{
    exit();
}

include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuestions.php");
include("../Modele/ModeleReponses.php");
include("../Modele/ModeleAssociationQuestionCours.php");
include("../Modele/ModeleAssociationTypesQuizQuestion.php");
include("../Modele/ModeleQuestionsVraiFaux.php");


$tableauQuestion = $_POST['tableauQuestion'];
$tableauReponses = $_POST['tableauReponses'];
$tableauCours = $_POST['tableauCours'];
$typeQuestion = $_POST['typeQuestion'];
//TODO What is this line : 54 ??? Nécessite expliquation sommaire
isset($_POST['tableauTypeQuizAssocie'])?$tableauTypeQuizAssocie = $_POST['tableauTypeQuizAssocie'] : $tableauTypeQuizAssocie = null;

modifierUneQuestion($tableauQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie);