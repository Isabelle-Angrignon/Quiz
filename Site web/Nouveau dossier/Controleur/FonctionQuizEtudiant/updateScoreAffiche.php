<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  updateScoreAffiche.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Récupère un résultat par POST et met à jour les variables de session du score
//        retourne ensuite un string de "note / total"
//
//  POST: 'resultat' = 1|0
//
//  Session :  'questionsRepondues' = Nobre de réponses données depuis le début du quiz.  S'incrémente à chaque question
//              répondue.  Ne pas confondre avec le nombre total de questions à répondre.
//              'bonnesReponses' = la somme des résultats
//
//  Sortie :  string "note / total"
//
////////////////////////////////////////////////////////////////////////////////////////////////////

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$reussi = $_POST['resultat'];

if (!isset($_SESSION['questionsRepondues']))
{
    $_SESSION['questionsRepondues'] = 1;
}
else
{
    $_SESSION['questionsRepondues'] += 1;
}

if (!isset($_SESSION['bonnesReponses']))
{
    if($reussi)
    {
        $_SESSION['bonnesReponses'] = 1;
    }
    else
    {
        $_SESSION['bonnesReponses'] = 0;
    }
}
else
{
    $_SESSION['bonnesReponses'] += $reussi;
}

echo $_SESSION['bonnesReponses'] . ' / ' .  $_SESSION['questionsRepondues'];


