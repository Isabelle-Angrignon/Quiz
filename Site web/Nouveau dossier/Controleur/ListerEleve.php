<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListerEleve.php
//  Fait par : Simon Bouchard
//  Fait le : 12/11/2014
//
//  Description :
//  Fichier répondant a un appel ajax de type post et qui retourne tout les usagers dont le numero de
//  DA ne commence pas par 4 sous format de JSON (en bref les étudiants)
//
//  Retour : JSON - Tout les étudiants (DA,nom,prenom)
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleEtudiants.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  json_encode(LireEtudiant());

echo $result;

?>
