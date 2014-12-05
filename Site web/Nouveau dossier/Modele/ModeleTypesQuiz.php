<?php

function listerTypesQuiz()
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerTypesQuiz()");

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}
