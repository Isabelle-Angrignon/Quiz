<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  nommerAdmin.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier qui répond a un appel ajax de type post et qui permet nommer un nouvel administrateur
//
//  Retour : Le nombre de lignes affectés pas les changements dans la BD
//
//  Paramètre de Post : numeroDA = Le numero de da du professeur qui deviendra administrateur
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');

nommerUnAdmin($_POST['numeroDA']);

function nommerUnAdmin($NumeroDA){
    try {
        $retour = nommerAdmin($NumeroDA);
        echo $retour;
    }
    catch (PDOException $e)
    {
        echo $e;
    }
}

?>
