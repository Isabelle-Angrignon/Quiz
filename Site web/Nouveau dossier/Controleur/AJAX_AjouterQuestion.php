<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AJAX_AjouterQuestion
//  Par: Mathieu Dumoulin
//  Date: 15/10/2014
//
//  Description :
//  Ce fichier effectue le contrôle entre la BD et la vue en ce qui à
//  trait d'un ajout de question à l'aide d'AJAX
//
////////////////////////////////////////////////////////////////////////////////////////////////////
//TODO devrait penser a indiquer les parametre post que le fichier prend
$doitArreter = false;
// Gestion des erreurs par programmation

if(isset($_POST['tableauQuestion']))
{
    $question = $_POST['tableauQuestion'];
}
else
{
    // Si je n'ai pas de question passé dans le POST
    echo "Vous devez envoyer une question à ajouter";
    // Quitte le script PHP
    exit();
}

if($question['enonceQuestion'] == "")
{
    echo "Vous devez entrer un énoncé à votre question.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauReponses']))
{
    echo "Vous devez entrer au moins une réponse.   ";
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
    // Quitte le script PHP
    exit();
}

// Si tous les paramètres passés en post sont valides
include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuestions.php");
include("../Modele/ModeleReponses.php");
include("../Modele/ModeleAssociationQuestionCours.php");
include("../Modele/ModeleAssociationTypesQuizQuestion.php");
include("../Modele/ModeleQuestionsVraiFaux.php");

// Simplifie la lecture si c'est de simple variable comparé à des $_POST['...']
$tableauQuestion = $_POST['tableauQuestion'];
$tableauReponses = $_POST['tableauReponses'];
$tableauCours = $_POST['tableauCours'];
$typeQuestion = $_POST['typeQuestion'];
isset($_POST['tableauTypeQuizAssocie'])? $tableauTypeQuizAssocie = $_POST['tableauTypeQuizAssocie'] : $tableauTypeQuizAssocie = null;


ajouterUneQuestion($tableauQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie);