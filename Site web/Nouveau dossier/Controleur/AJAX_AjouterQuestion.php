<?php
/*  AJAX_AjouterQuestion
 *  Par: Mathieu Dumoulin
 *  Date: 15/10/2014
 *  Description : Ce fichier effectue le contrôle entre la BD et la vue en ce qui à trait d'un ajout de question à l'aide d'AJAX
 */
$doitArreter = false;
if(!isset($_POST['tableauQuestion']))
{
    echo "tableauQuestion du post n'est pas set.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauReponses']))
{
    echo "Ajout de la question ne s'est pas fait car elle ne contient aucune réponse.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauCours']))
{
    echo "tableauCours du post n'est pas set.   ";
    $doitArreter = true;
}
if(!isset($_POST['typeQuestion']))
{
    echo "typeQuestion du post n'est pas set.   ";
    $doitArreter = true;
}
if(!isset($_POST['tableauTypeQuizAssocie']))
{
    echo "tableauTypeQuizAssocie du post n'est pas set";                                            //A DEMANDER A ISA POUR SAVOIR SI ÇA PEUT ÊTRE NULL
    $doitArreter = true;
}

if($doitArreter)
{
    exit();
}

include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuestions.php");

$tableauQuestion = json_encode($_POST['tableauQuestion']);
$tableauReponses = json_encode($_POST['tableauReponses']);
$tableauCours = json_encode($_POST['tableauCours']);
$typeQuestion = $_POST['typeQuestion'];
$tableauTypeQuizAssocie = json_encode($_POST['tableauTypeQuizAssocie']);

/*echo "tableauQuestion = ".$tableauQuestion;
echo "tableauReponses = ".$tableauReponses;
echo "tableauCours = ".$tableauCours;
echo "typeQuestion = ".$typeQuestion;
echo "tableauTypeQuizAssocie = ".$tableauTypeQuizAssocie;*/

ajouterUneQuestion($tableauQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie);