<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  listerQuestionsFormatif.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Génère la liste des questions associées au quiz choisi en les ordonnant selon que l'ordre est sensée être
//        aléatoire ou non.  Charge ensuite les éléments de la première question à répondre dans les variables de session
//
//  POST:  'idQuiz' et 'ordreQuestionsEstAleatoire'
//
//  Session :  'listeQuestions' = array d'idQuestion à répondre: utiliser pour charger chaque question au fur et à mesure
//              'listeQuestionRepondues' =  array d'idQuestion répondues: sera utile pour mettre à jour les stats
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

$idQuiz = $_POST['idQuiz'];
$ordeQuestionsEstAleatoire = $_POST['ordreQuestionsEstAleatoire'];

//devra fair un switch case selon le type de quiz...
$Liste = genererQuestionsQuiz($idQuiz);

if (isset($Liste) && !empty($Liste) && isset($ordeQuestionsEstAleatoire))
{
    if ($ordeQuestionsEstAleatoire == 1)
    {
        shuffle($Liste);
    }
    $_SESSION["listeQuestions"] = $Liste;

    //Preparer premiere question
    $idQuestion = $_SESSION['listeQuestions'][0];

    $_SESSION['listeQuestionRepondues'][0] = $idQuestion['idQuestion'];

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


