<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$score = ceil($_SESSION['bonnesReponses'] *100 / $_SESSION['questionsRepondues']);
$resultat = $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'] . " (" . $score . "%) " /*. print_r($_SESSION['listeQuestionRepondues']) . print_r($_SESSION['bienRepondu']) */;

if ( $score == 100)
{
    echo "Bravo! Score parfait! " . $resultat ;
}
elseif ($score <= 60)
{
    echo "Ouf! une révision s'impose! " . $resultat ;
}
else
{
    echo "Score final: " . $resultat;
}