<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListerCours.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post en lui retournant la liste
//  de tout les cours en format JSON
//
//  Retour : JSON - Tout les cours (id, nomCours , codeCours)
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$resultat = json_encode(LireCours());
echo $resultat;
?>