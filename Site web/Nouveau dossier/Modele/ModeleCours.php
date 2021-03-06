<?php
//LireCours
//Fait par : Simon Bouchard
//Intrant : Aucun
//Extrant : Le résultat de la requête
// Permet de recevoir un tableau contenant tout les cours stocké dans la base de donnée
//
function LireCours()
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerCours()");
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

function AjouterCours($nomCours, $CodeCours)
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL AjouterCours(?,?)");
    $requete->bindparam(1, $nomCours, PDO::PARAM_STR,200);
    $requete->bindparam(2, $CodeCours, PDO::PARAM_STR,10);
    $requete->execute();

    $requete->closeCursor();
    unset($bdd);
}

function ModifierCours($IdCours,$nomCours, $CodeCours)
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL modifierCours(?,?,?)");
    $requete->bindparam(1, $IdCours, PDO::PARAM_INT);
    $requete->bindparam(2, $nomCours, PDO::PARAM_STR,200);
    $requete->bindparam(3, $CodeCours, PDO::PARAM_STR,10);
    $requete->execute();

    $requete->closeCursor();
    unset($bdd);
}


?>