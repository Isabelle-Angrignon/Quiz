<?php
//LireÉtudiant
//Fait par : Simon Bouchard
//Intrant : Aucun
//Extrant : Le résultat de la requête
//Liste tout les étudiants et les retournes sous la forme d'un tableau tab[row][collumn name]
function LireEtudiant()
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerEtudiants()");
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

?>