<?php
//LireCours
//Fait par : Simon Bouchard
//Intrant : Aucun
//Extrant : Le résultat de la requête
// Permet de recevoir un tableau contenant tout les cours stocké dans la base de donnée
//
function LireCours()
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerCours()");
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}


?>