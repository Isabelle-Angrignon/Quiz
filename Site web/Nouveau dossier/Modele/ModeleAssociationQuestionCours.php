<?php

// listerCoursSelonQuestion
// Par: Mathieu Dumoulin
// Date: 14/10/2014
// Description: Cette fonction appelle la procédure stockée "listerCoursSelonQuestion" et retourne son résultat sous forme de JSON
function listerCoursSelonQuestion($idQuestion)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerCoursSelonQuestion(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

function associerQuestionACours($connexion, $idQuestion, $idCours) {
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL associerQuestionCours(?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $idCours, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la liaison de la question avec le cours : " . $idCours);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function dissocierQuestionACours($connexion, $idQuestion) {
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL supprimerLienQuestionCours(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la suppression de la liaison de la question : " . $idQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}