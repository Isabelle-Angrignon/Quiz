<?php


function listerTypesQuizAssocie($idQuestion)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listertypesquizassocie(?)");

    $requete->bindparam(1, $idQuestion, PDO::PARAM_INT);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

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

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}