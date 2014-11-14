<?php

include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//cFonctionsQuizEtudiant.php");
include ("..//..//Modele/ModeleQuiz.php");

demarrerSession();
redirigerSiNonConnecte('Etudiant');

//on aura besoin du id de quiz dans la mise a jour des stats quiz...

$_SESSION['idQuiz'] = $_POST['selectQuiz'];
$_SESSION['titreQuiz'] = $_POST['titreQuiz'];
$_SESSION['idProf'] = $_POST['idProf'];
$_SESSION['nomProf'] = $_POST['nomProf'];


if (isset ($_SESSION['idQuiz']))
{
    $info = recupererInfoQuiz($_SESSION['idQuiz']);
    $_SESSION['typeQuiz'] = $info['typeQuiz'];
    $_SESSION['ordreQuestionsEstAleatoire'] = $info['ordreQuestionsAleatoire'];
}

//Remet a vide les variables de session reliées au quiz.
//Tel la liste des questions et autres.
resetVarSessionQuiz();




