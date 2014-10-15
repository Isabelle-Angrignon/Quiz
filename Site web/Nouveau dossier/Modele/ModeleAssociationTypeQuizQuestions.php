<?php

function associerTypeQuizQuestion($connexion, $idQuestion, $typeQuiz)
{
    if(isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL associerQuestionTypeQuiz(?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $typeQuiz, PDO::PARAM_STR, 20);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }

    return $resultat;
}