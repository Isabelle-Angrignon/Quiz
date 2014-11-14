<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ModifierCours.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post afin de modifier un cours
//
//  Paramètre en post : idCours = l'id du cours a modifier , nomCours = nouveau nom du cours,
//  codeCours = le nouveau code du cours
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');
ModifierCours($_POST['idCours'],$_POST['nomCours'],$_POST['codeCours']);
?>