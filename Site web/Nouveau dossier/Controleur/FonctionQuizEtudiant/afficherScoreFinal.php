<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");

include("..//..//Modele/ModeleStatistiques.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$score = ceil($_SESSION['bonnesReponses'] *100 / $_SESSION['questionsRepondues']);
$resultat = $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'] . " (" . $score . "%) " /*. print_r($_SESSION['listeQuestionRepondues']) . print_r($_SESSION['bienRepondu']) */;

if ( $score == 100)
{
    $resultat =  "Bravo! Score parfait! " . $resultat ;
}
elseif ($score <= 60)
{
    $resultat = "Ouf! une révision s'impose! " . $resultat ;
}
else
{
    $resultat = "Score final: " . $resultat;
}


if (isset($_SESSION['typeQuiz']))
{
    $resultat = $resultat .  "   dans type de quiz!!!!";
    if($_SESSION['typeQuiz'] == "FORMATIF")
    {
        $resultat =  $resultat . "  " . miseAJourStatsQuiz();
    }
}

echo $resultat;