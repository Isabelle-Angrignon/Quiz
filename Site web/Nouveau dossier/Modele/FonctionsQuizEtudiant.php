<?php
/**
 * Created by PhpStorm.
 * User: Isabelle
 * Date: 2014-09-30
 * Time: 13:03
 */
function genererQuestionsAleatoires($cours)
{
    $QuizAleatoire = array();

    // a retirer et mettre connecterEtudiant
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');

    if (isset($cours))
    {
        $requete = $bdd->prepare("CALL genererQuestionsAleatoires(?)");
        $requete->bindparam(1, $cours, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $QuizAleatoire = $requete->executeQuery();
        }

        echo 'test isa' + $QuizAleatoire;

        while($ligneAffectee = $requete->fetch())
        {
            lireQuestion($ligneAffectee);
        }
    }
}

function lireQuestion($ligneQuestion)
{
    $idQuestion = $ligneQuestion[0];
    $enonceQuestion = $ligneQuestion[1];
    $imageQuestion = $ligneQuestion[2];
    $ordreReponsesAleatoire = $ligneQuestion[3];
    $typeQuestion = $ligneQuestion[4];
    $idUsager_Proprietaire = $ligneQuestion[5];
    $referenceWeb = $ligneQuestion[6];
    $typeQuiz = $ligneQuestion[7];
    $idCours = $ligneQuestion[8];

    echo $idQuestion + ', ' + $enonceQuestion + ', ' + $imageQuestion + ', ' +
            $ordreReponsesAleatoire + ', ' + $typeQuestion + ', ' +
            $idUsager_Proprietaire + ', ' + $referenceWeb + ', ' +
            $typeQuiz + ', ' + $idCours + '. ' ;
}



?>