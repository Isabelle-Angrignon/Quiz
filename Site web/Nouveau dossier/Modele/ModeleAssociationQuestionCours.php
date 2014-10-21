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

    if(isset($connexion))
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

    $requete->execute();

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}