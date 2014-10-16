<?php
/*  AJAX_AjouterQuestion
 *  Par: Mathieu Dumoulin
 *  Date: 15/10/2014
 *  Description : Ce fichier effectue le contrôle entre la BD et la vue en ce qui à trait d'un ajout de question à l'aide d'AJAX
 */

if(!isset($_POST['tableauQuestion']))
{
    echo "<script> alert('tableauQuestion du post nest pas set);</script>";
    exit();
}
if(!isset($_POST['tableauReponses']))
{
    echo "<script> alert('tableauReponses du post nest pas set);</script>";
    exit();
}
if(!isset($_POST['typeQuestion']))
{
    echo "<script> alert('typeQuestion du post nest pas set);</script>";
    exit();
}
if(!isset($_POST['tableauTypeQuizAssocie']))
{
    echo "<script> alert('tableauTypeQuizAssocie du post nest pas set);</script>";
    exit();
}

$tableauQuestion = json_decode($_POST['tableauQuestion']);
$tableauReponses = json_decode($_POST['tableauReponses']);
$tableauCours = json_decode($_POST['tableauCours']);
$typeQuestion = $_POST['typeQuestion'];
$tableauTypeQuizAssocie = json_decode($_POST['tableauTypeQuizAssocie']);