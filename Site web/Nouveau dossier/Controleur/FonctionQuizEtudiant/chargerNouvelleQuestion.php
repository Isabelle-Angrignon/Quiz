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
        array_shift($_SESSION['listeQuestions']);
    }
    else
    {
        resetVarSessionQuiz();
    }
    // rien a dire
    echo '0';
}
else
{
    // affiche le message de ton choix
    echo '1';
}

