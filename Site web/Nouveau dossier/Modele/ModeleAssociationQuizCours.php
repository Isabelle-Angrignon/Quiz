<?php


function listerCoursSelonQuiz($idQuiz)
{
    $bdd = connecterProf();

    $requete = $bdd->prepare("CALL listerCoursSelonQuiz(?)");

    $requete->bindParam(1,$idQuiz, PDO::PARAM_INT);

    $requete->execute();

    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

function associerQuizCours($connexion, $idQuiz, $idCours)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL associerQuizCours(?,?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);
    $requete->bindParam(2, $idCours, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la liaison du quiz avec le cours : " . $idCours);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function supprimerLienQuizCours($connexion, $idQuiz)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL supprimerLienQuizCours(?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la suppression de la liaison du quiz : " . $idQuiz);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}