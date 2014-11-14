<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AjouterEtudiantCours.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Desciription :
//  Fonction répondant a un appel ajax permettant d'inscrire un étudiant
//
//  Paramètre post :
//  idE = id de l'étudiant , nom = nom de l'étudiant, prenom= prénom de l'étudiant ,
//  idCours = id du cours dans lequel l'étudiant sera ajouter
//
//  Paramètre session :
//  idUsager = Permet d'inscrire l'étudiant au cours du prof qui fait
//  actuellement le changement
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  InscrireEtudiantCours($_POST['idE'],$_POST['nom'],$_POST['prenom'],$_POST['idCours'], $_SESSION['idUsager']);



?>
