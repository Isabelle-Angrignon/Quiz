<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  seDeconnecter.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Appeler lorsque on souhaite se déconnecter
//
//  Redirection : index.php
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Usager');
session_destroy();  // supprime le fichier de session
header('location: ../index.php');


?>