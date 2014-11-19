<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  setInfoQuizSession.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Appelle la méthode  du "modèle" pour récupérer les attributs manquants à la gestion du nouveau quiz et met les
//        éléments névessaires dans les variables de session.
//        libère ensuite les variables de session reliées à une question spécifique qui pourraient ne pas être effacées
//        lors du dernier quiz
//
//  POST:  'selectQuiz', 'titreQuiz', 'idProf' et 'nomProf'
//
//  Session :  'idQuiz', 'titreQuiz', 'idProf', 'nomProf', 'typeQuiz' et 'ordreQuestionsEstAleatoire'
//
//  Sortie :  aucune
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//cFonctionsQuizEtudiant.php");
include ("..//..//Modele/ModeleQuiz.php");

demarrerSession();
redirigerSiNonConnecte('Etudiant');

//on aura besoin du id de quiz dans la mise a jour des stats quiz...
$_SESSION['idQuiz'] = $_POST['selectQuiz'];
//Pour l'affichage de l'entête
$_SESSION['titreQuiz'] = $_POST['titreQuiz'];
$_SESSION['idProf'] = $_POST['idProf'];
$_SESSION['nomProf'] = $_POST['nomProf'];

if (isset ($_SESSION['idQuiz']))
{
    $info = recupererInfoQuiz($_SESSION['idQuiz']);
    //Pour la gestion du quiz en tant que tel
    $_SESSION['typeQuiz'] = $info['typeQuiz'];
    $_SESSION['ordreQuestionsEstAleatoire'] = $info['ordreQuestionsAleatoire'];
}

//Remet a vide les variables de session reliées au quiz.
//Tel la liste des questions et autres.
resetVarSessionQuiz();




