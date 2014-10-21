<?php
include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');



// bonnesReponses
// questionsRepondues

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
    if($reussi == 1)
    {
        $_SESSION['bonnesReponses'] += 1;
    }
}

echo $_SESSION['bonnesReponses'] . ' / ' .  $_SESSION['questionsRepondues'];


