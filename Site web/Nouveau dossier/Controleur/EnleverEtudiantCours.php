<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  EnleverEtudiantCours.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post afin de désinscrire un étudiant d'un cours.
//
//  Parametre Post : idE = numero de Da de l'étudiant , idCours = id du cours dont on veut désinscrire l'étudiant
//
//  Parametre de Session : idUsager = le id du prof qui désinscrit l'étudiant
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  desinscrireEtudiantCours($_POST['idE'],$_POST['idCours'], $_SESSION['idUsager']);


?>
