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
    $bdd = connecterProf();

    $requete = $bdd->prepare("CALL listerCoursEtudiant( ? )");
    $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

function LireEtudiantDansUnCours($idCours, $IdProf)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL ListerEtudiantUnCours(? , ?)");
    $requete->bindparam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindparam(2, $IdProf, PDO::PARAM_STR,10);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);

}

function LireEtudiantPasDansUnCours($idCours, $IdProf)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL ListerEtudiantPasDansUnCours(? , ?)");
    $requete->bindparam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindparam(2, $IdProf, PDO::PARAM_STR,10);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);

}

function InscrireEtudiantCours($idEtudiant , $nom , $prenom, $idCours, $idProf)
{
    $bdd = connecterProf();
    if (isset($idEtudiant) AND isset($prenom) AND isset($nom))
    {
        $requete = $bdd->prepare("CALL inscrireEtudiantCours(?, ?, ? , ? ,?)");
        $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
        $requete->bindparam(2, $prenom, PDO::PARAM_STR,30);
        $requete->bindparam(3, $nom, PDO::PARAM_STR,50);
        $requete->bindparam(4, $idCours, PDO::PARAM_INT,10);
        $requete->bindparam(5, $idProf, PDO::PARAM_STR,10);

        $requete->execute();

        $ligneAffectee = $requete->fetch();
        $requete->closeCursor();
        unset($bdd);
        return $ligneAffectee;
    }
    else{
        echo "shit";
    }
}

function desinscrireEtudiantCours($idEtudiant , $idCours, $idProf)
{
    $bdd = connecterProf();
    if (isset($idEtudiant) AND isset($idCours) AND isset($idProf))
    {
        $requete = $bdd->prepare("CALL desinscrireEtudiantCours(?, ?, ?)");
        $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
        $requete->bindparam(2, $idCours, PDO::PARAM_INT,10);
        $requete->bindparam(3, $idProf, PDO::PARAM_STR,10);

        $requete->execute();

        $ligneAffectee = $requete->fetch();
        $requete->closeCursor();
        unset($bdd);
        return $ligneAffectee;
    }
    else{
        echo "shit";
    }
}


?>