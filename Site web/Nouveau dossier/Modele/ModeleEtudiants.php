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


?>