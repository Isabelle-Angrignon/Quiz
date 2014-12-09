<?php

if(!isset($_POST['idQuiz']))
{
    echo "La suppression nécéssite un identifiant de quiz. Cet identifiant n'est jamais reçu dans la fonction.";
    exit();
}

session_start();
include("cFonctionsProf-GererQuiz.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuiz.php");

supprimerUnQuiz($_POST['idQuiz']);