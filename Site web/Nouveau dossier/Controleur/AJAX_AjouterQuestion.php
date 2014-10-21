<?php
/*  AJAX_AjouterQuestion
 *  Par: Mathieu Dumoulin
 *  Date: 15/10/2014
 *  Description : Ce fichier effectue le contrôle entre la BD et la vue en ce qui à trait d'un ajout de question à l'aide d'AJAX
 */
$doitArreter = false;
$question = $_POST['tableauQuestion'];
if($question['enonceQuestion'] == "")
{
    echo "Vous devez entrer un énoncé à votre question.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauReponses']))
{
    echo "Ajout de la question ne s'est pas fait car elle ne contient aucune réponse.   ";
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
if(!isset($_POST['tableauTypeQuizAssocie']))
{
    echo "Vous devez lier la question à un type de quiz.   ";
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
include("Utilitaires.php");

$tableauQuestion = $_POST['tableauQuestion'];
$tableauReponses = $_POST['tableauReponses'];
$tableauCours = $_POST['tableauCours'];
$typeQuestion = $_POST['typeQuestion'];
$tableauTypeQuizAssocie = $_POST['tableauTypeQuizAssocie'];

/*echo $tableauQuestion['enonceQuestion']."         ";
foreach($tableauReponses['reponses'] as $reponses)
{
    echo $reponses['enonce']."       ";
}
foreach($tableauCours['cours'] as $cours)
{
    echo $cours['nomCours']."         ";
}

echo $typeQuestion."        ";
echo $tableauTypeQuizAssocie."        ";*/


ajouterUneQuestion($tableauQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie);