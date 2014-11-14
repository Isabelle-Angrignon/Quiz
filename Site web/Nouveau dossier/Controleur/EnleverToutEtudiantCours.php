<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
// EnleverToutÉtudiantCours.php
// Fait par : Simon Bouchard
// Commenter le : 12/11/2014
//
//  Description :
//  Ce fichier désinscrit tout les étudiants d'un cours en réponse a un appel ajax de type post.
//
//  Parametre Post : idCours = id du cours dont on veut désinscrire tout les étudiants
//
//  Session : idUsager = l'id du professeur qui souhaite désinscire tout les étudiants de son cours
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  desinscrireToutEtudiantCours($_POST['idCours'], $_SESSION['idUsager']);




?>
