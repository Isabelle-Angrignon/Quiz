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