<?php

/*
    Nom: LireCoursEtudiant
    Par: Simon Bouchard, adapté par Isabelle Angrignon
    Date: 03/10/2014
    Intrants: $idEtudiant = Le id d'un étudiant
    Extrant(s): Tableau de cours: idCours, codeCours, nomCours, idProfesseur
    Description: Cette fonction communique à la BD et récupère La liste des cours auquel cet étudiant est inscrit
*/
function LireCoursEtudiant($idEtudiant)
{
    $bdd = connecterEtudiant();
    $requete = $bdd->prepare("CALL listerCoursEtudiant( ? )");
    $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}




?>