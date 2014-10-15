<?php
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include "..//..//Modele/ModeleUsagers.php";
include("..//cFonctionsQuizEtudiant.php");
include("..//..//Modele/ModeleQuestions.php");
demarrerSession();
redirigerSiNonConnecte();

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
        echo "Quiz terminé.  Score final: " . $_SESSION['bonnesReponses'] . " / " . $_SESSION['questionsRepondues'];
        resetVarSessionQuiz();
    }
}
else
{
    echo "Il n'y a aucune question aléatoire de créée pour ce cours.";
}


/*
//gestion des question du quiz...
if (isset($_SESSION["listeQuestions"]))
{
    if (!empty($_SESSION["listeQuestions"])) {
        echo ' <script>creeFrameDynamique("QuestionAleatoire", "Vue/dynamique-RepondreQuestion.php")</script> ';
        //retirer la première question de la liste, elle est récupérée au début de la page
        /////////////////////next
    }
    else
    {
        resetVarSessionQuiz();
    }
}*/
