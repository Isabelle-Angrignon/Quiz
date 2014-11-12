<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

function unsetInfoQuizSession()
{
    unset($_SESSION['idQuiz']);
    unset($_SESSION['titreQuiz']);
    unset($_SESSION['idProf']);
    unset($_SESSION['nomProf']);
    unset($_SESSION['typeQuiz']);
    unset($_SESSION['ordreQuestionsEstAleatoire']);
}

if (!empty($_SESSION['listeQuestions']))
{
    echo '0';
}
else
{
    unsetInfoQuizSession();
    echo '1';
}