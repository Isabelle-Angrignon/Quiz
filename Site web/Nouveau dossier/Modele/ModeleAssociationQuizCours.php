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