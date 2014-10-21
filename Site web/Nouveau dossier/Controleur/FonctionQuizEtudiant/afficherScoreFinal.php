<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$score = ceil($_SESSION['bonnesReponses'] *100 / $_SESSION['questionsRepondues']);
$resultat = $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'] . " (" . $score . "%) ";

if ( $score == 100)
{
    echo "Bravo! Score parfait! " . $resultat ;
}
elseif ($score <= 60)
{
    echo "Ouf! une révision est nécessaire! " . $resultat;
}
else
{
    echo "Score final: " . $resultat;
}