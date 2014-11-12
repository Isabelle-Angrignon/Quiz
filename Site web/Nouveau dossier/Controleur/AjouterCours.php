<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AjouterCours.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Descritpion :
//  Fonction php servant a faire le lien en le modelCours et la fonction ajax qui crée un cours.
//
//  Parametre Post :
//  nom= le nom du cours , code= le code du cours
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
AjouterCours($_POST['nom'],$_POST['code']);

?>