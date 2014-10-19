<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
demarrerSession();
redirigerSiNonConnecte();

$score = ceil($_SESSION['bonnesReponses'] *100 / $_SESSION['questionsRepondues']);
$resultat = $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'] . " (" . $score . "%) ";

if ( $score == 100)
{
    echo "Quiz terminé.  Bravo! Score parfait! " . $resultat ;
}
elseif ($score <= 60)
{
    echo "Quiz terminé.  Ouf! une révision est nécessaire! " . $resultat;
}
else
{
    echo "Quiz terminé.  Score final: " . $resultat;

}