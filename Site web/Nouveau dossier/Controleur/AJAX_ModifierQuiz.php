<?php



$doitArreter = false;
if(!isset($_POST['idQuiz']))
{
    echo "Vous devez entrer l'identifiant du quiz à modifier.";
    $doitArreter = true;
}
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

session_start();
include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuiz.php");
include("../Modele/ModeleAssociationQuizCours.php");

$idQuiz = $_POST['idQuiz'];
$titreQuiz = $_POST['titreQuiz'];
$ordreEstAleatoire = $_POST['ordreEstAleatoire'];
$idProprietaire = $_POST['idProprietaire'];
$estDisponible = $_POST['estDisponible'];
$jsonCours = $_POST['jsonCours'];


modifierUnQuiz($idQuiz, $titreQuiz, $ordreEstAleatoire ,$idProprietaire, $estDisponible , $jsonCours);

