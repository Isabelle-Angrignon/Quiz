<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  chargerNouvelleQuestion.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Appelle la méthode  du "modèle" pour récupérer les attributs de la prochaine question à poser dans le quiz
//        Transfert le idQuestion de la dernière question posée d'une variable de session à une autre, soit:
//        de la liste des questions vers poser à la liste de questions posées.  On tire et pousse toujours du début de la liste
//        S'il ne reste plus de questions à poser, libère alors les variables de session reliées à la
//        dernière question posée.
//
//  POST:  aucun
//
//  Session :  'listeQuestions' = array d'idQuestion à répondre: utilisé pour charger chaque question au fur et à mesure
//              'listeQuestionRepondues' =  array d'idQuestion répondues: sera utile pour mettre à jour les stats
//              Les deux listes sont vidées et remplies par le début (position 0) avec array_shift ou array_unshift
//              'infoQuestion' = array des différents attributs d'une question
////
//  Sortie :  aucune
//
////////////////////////////////////////////////////////////////////////////////////////////////////

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

