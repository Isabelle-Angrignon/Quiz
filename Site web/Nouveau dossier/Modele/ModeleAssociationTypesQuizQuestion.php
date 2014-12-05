<?php


function listerTypesQuizAssocie($idQuestion)
{
    $bdd = getConnection();
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
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL associerQuestionTypeQuiz(?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $typeQuiz, PDO::PARAM_STR, 20);


    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la liaison de la question avec le type de quiz : " .$typeQuiz );
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function dissocierTypeQuizQuestion($connexion, $idQuestion)
{
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL supprimerLienQuestionTypeQuiz(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la suppression de la liaison des types de quiz avec la question : " . $idQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}