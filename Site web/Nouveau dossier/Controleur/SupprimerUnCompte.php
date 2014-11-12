<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  SupprimerUnCompte.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Ce fichier change le e-mail d'un usager suite a un appel de type post afin de supprimer un compte
//
//  Parametre en post :
//  numeroDA = Le numero de DA de l'étudiant que l'on souhaite supprimer
//
//  Retour : Nombre de lignes affecté par les changement dans la BD
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');

SupprimerCompte($_POST['numeroDA']);

function SupprimerCompte($NumeroDA){
    try {
        $retour = SupprimerUnCompte($NumeroDA);
        echo $retour;
    }
    catch (PDOException $e)
    {
        echo $e;
    }
}

?>
