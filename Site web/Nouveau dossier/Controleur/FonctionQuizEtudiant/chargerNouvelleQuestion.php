<?php

include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//cFonctionsQuizEtudiant.php");
include("..//..//Modele/ModeleQuestions.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

if (isset($_SESSION['listeQuestions']) )
{
    if (!empty($_SESSION['listeQuestions']))
    {
        $idQuestion = $_SESSION['listeQuestions'][0];
        //recupérer infos question
        $_SESSION['infoQuestion'] = recupererElementsQuestion($idQuestion['idQuestion']);

        //Les derniers éléments traités sont alors en position [0]
        array_unshift($_SESSION['listeQuestionRepondues'], $idQuestion['idQuestion']);//met au début de la file
        array_shift($_SESSION['listeQuestions']);//retire du début de la file
    }
    else
    {
        resetVarSessionQuiz();
    }
    echo '0';
}
else
{
    echo 'Pas de liste';
}

