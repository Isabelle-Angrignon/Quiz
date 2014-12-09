<?php
// listerQuizProf-GererQuiz.php
// Par Mathieu Dumoulin
// Description : Ce fichier est utilisé par AJAX pour lister les quiz d'un cours et d'un propriétaire

include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuiz.php");
session_start();
if(isset($_POST['idCours']) && isset($_POST['idProprietaire']))
{
    $listeQuiz = listerQuizSelonCoursProprietaire($_POST['idCours'], $_POST['idProprietaire']);
    echo $listeQuiz;
}