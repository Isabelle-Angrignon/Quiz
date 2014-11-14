<?php


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



$titreQuiz = $_POST['titreQuiz'];
$ordreEstAleatoire = $_POST['ordreEstAleatoire'];
$estDisponible = $_POST['estDisponible'];
$jsonCours = $_POST['jsonCours'];