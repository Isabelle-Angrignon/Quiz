<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  GenererQuestionsAleatoires.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Génère la liste mélangée de toutes les questions associées au type de quiz aléatoire en fonction du cours choisi
//        Charge ensuite les éléments de la première question à répondre dans les variables de session
//
//  POST:  aucun
//
//  Session :   'idCours' = tel que sélectionné dans le menu cours
//              'listeQuestions' = array d'idQuestion à répondre: utiliser pour charger chaque question au fur et à mesure
//              Les deux listes sont vidées et remplies par le début (position 0) avec array_shift et array_unshift
//              'infoQuestion' = array des différents attributs d'une question
//
//  Sortie :  int 1|0 selon qu'on a obtenu une liste de questions pour ce quiz
//
////////////////////////////////////////////////////////////////////////////////////////////////////

include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//..//Modele/mFonctionsQuizEtudiant.php");
include("..//cFonctionsQuizEtudiant.php");
include("..//..//Modele/ModeleQuestions.php");

demarrerSession();
redirigerSiNonConnecte('Etudiant');

$cours = $_SESSION['idCours'];

$Liste = genererQuestionsAleatoires($cours);

if (isset($Liste) && !empty($Liste))
{
    shuffle($Liste);// ne pas réassigner a un array, les éléments sont mélengés à même la variable.

    $_SESSION["listeQuestions"] = $Liste;
    //Preparer premiere question
    $idQuestion = $_SESSION['listeQuestions'][0];

    //On définit le type de quiz ici pour l'affichage
    $_SESSION['typeQuiz'] = "ALEATOIRE";
    //recupérer infos question
    $_SESSION['infoQuestion'] = recupererElementsQuestion($idQuestion['idQuestion']);
    array_shift($_SESSION['listeQuestions']);
    echo '1';
}
else
{
    echo '0' ;
}

?>


