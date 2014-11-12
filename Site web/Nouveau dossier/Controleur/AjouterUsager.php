<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  AjouterUsager.php
//  Fait par : Simon Bouchard
//  Commenté le : 12/11/2014
//
//  Desciprtion :
//  Fichier servant a créer des usagers en répondant a un appel ajax
//
//  Retour :  le nombre de lignes affectés dans la BD (ou créer)
//
//  Parametre en Post : idUsager = numero de DA de l'étudiant , nom = nom de l'étudiant , prenom = prénom de l'étudiant
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');

CreerUsager($_POST['idUsager'], $_POST['nom'],$_POST['prenom']);

function CreerUsager($idEleve,$nom,$prenom)
{
    try {
        $retour = ajouterUsager($idEleve, $nom, $prenom);
        echo $retour;
    }
    catch (PDOException $e){
        echo 0;
    }
}
?>