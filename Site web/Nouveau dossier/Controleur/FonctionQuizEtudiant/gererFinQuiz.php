<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");

include("..//..//Modele/ModeleStatistiques.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');



// Gestion de l'affichage du résultat du quiz à l'écran
$score = ceil($_SESSION['bonnesReponses'] *100 / $_SESSION['questionsRepondues']);
$resultat = $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'] . " (" . $score . "%) " ;

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


// Mise à jour des stats pour quiz non aléatoire
if (isset($_SESSION['typeQuiz']))
{
    if($_SESSION['typeQuiz'] == "FORMATIF")
    {
        miseAJourStatsQuiz();
    }
}

echo $resultat;