<?php


function listerTypesQuestions()
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerTypesQuestion()");

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}