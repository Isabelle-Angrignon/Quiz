<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListerElevePasDansCours.php
//  Fait par : Simon Bouchard
//  Fait le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post afin de donner une liste de tout les étudiants
//  qui ne sont pas dans un cours.
//
//  Retour : JSON - Tout les étudiants qui ne sont pas dans le cours (DA,nom,prenom)
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  LireEtudiantPasDansUnCours($_POST['idCours'], $_SESSION['idUsager']);

echo $result;

?>
