<?php
/*  AJAX_AjouterQuestion
 *  Par: Mathieu Dumoulin
 *  Date: 15/10/2014
 *  Description : Ce fichier effectue le contrôle entre la BD et la vue en ce qui à trait d'un ajout de question à l'aide d'AJAX
 */

if(!isset($_POST['tableauQuestion']))
{
    echo "tableauQuestion du post nest pas set";
    exit();
}
if(!isset($_POST['tableauReponses']))
{
    echo "tableauReponses du post nest pas set";
    exit();
}
if(!isset($_POST['typeQuestion']))
{
    echo "typeQuestion du post nest pas set";
    exit();
}
if(!isset($_POST['tableauTypeQuizAssocie']))
{
    echo "tableauTypeQuizAssocie du post nest pas set";
    exit();
}

$tableauQuestion = json_decode($_POST['tableauQuestion']);
$tableauReponses = json_decode($_POST['tableauReponses']);
$tableauCours = json_decode($_POST['tableauCours']);
$typeQuestion = $_POST['typeQuestion'];
$tableauTypeQuizAssocie = json_decode($_POST['tableauTypeQuizAssocie']);

echo "tableauQuestion = ".$tableauQuestion;
echo "tableauReponses = ".$tableauReponses;
echo "tableauCours = ".$tableauCours;
echo "typeQuestion = ".$typeQuestion;
echo "tableauTypeQuizAssocie = ".$tableauTypeQuizAssocie;