<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AJAX_AjouterQuiz
//  Par: Mathieu Dumoulin
//
//  Description :
//  Ce fichier récupère les informations passés dans le POST par rapport à un quiz et l'ajoute dans la BD.
//
////////////////////////////////////////////////////////////////////////////////////////////////////


$doitArreter = false;
if(!isset($_POST['titreQuiz']))
{
    echo "Vous devez entrer un titre à votre quiz.";
    $doitArreter = true;
}
if(!isset($_POST['ordreEstAleatoire']))
{
    echo "Votre quiz doit avoir un ordre selon lequel vos questions sont affichées.";
    $doitArreter = true;
}
if(!isset($_POST['idProprietaire']))
{
    echo "Vous devez être connecter pour ajouter un quiz.";
    $doitArreter = true;
}
if(!isset($_POST['estDisponible']))
{
    echo "Votre quiz doit possèder l'attribut de disponibilité.";
    $doitArreter = true;
}
if(!isset($_POST['jsonCours']))
{
    echo "Votre quiz doit être lier à un cours minimum.";
    $doitArreter = true;
}

if($doitArreter)
{
    exit();
}

// Si les paramètres du quiz sont valides
include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuiz.php");
include("../Modele/ModeleAssociationQuizCours.php");

$titreQuiz = $_POST['titreQuiz'];
$ordreEstAleatoire = $_POST['ordreEstAleatoire'];
$idProprietaire = $_POST['idProprietaire'];
$estDisponible = $_POST['estDisponible'];
$jsonCours = $_POST['jsonCours'];


ajouterUnQuiz($titreQuiz, $ordreEstAleatoire, $idProprietaire, $estDisponible , $jsonCours);

