<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListerEleveDansCours.php
//  Fait par : Simon Bouchard
//  Fait le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post afin de donner une liste des étudiants
//  qui se trouvent dans un cours spécifique
//
//  Paramètre post : idCour = Le cours servant a lister les étudiants
//
//  Paramètre session : idUsager = Le prof qui souhaite lister les étudiants de son cours
//
//  Retour : JSON - Tout les étudiants qui sont dans le cours (DA,nom,prenom)
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  LireEtudiantDansUnCours($_POST['idCours'], $_SESSION['idUsager']);

echo $result;

?>
