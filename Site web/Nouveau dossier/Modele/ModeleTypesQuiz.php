<?php

function listerTypesQuiz()
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerTypesQuiz()");

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}
