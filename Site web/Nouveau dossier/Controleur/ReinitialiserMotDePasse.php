<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ReinitialiserMotDePasse.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier répondant a un appel ajax de type post permet de réinitialiser le mot de passe d'un usager
//
//  Parametre en post :
//  numeroDA = Le numero de DA de l'usager dont le mot de passe doit être réinitialiser
//
//  Retour : Le nombre de lignes affecté par ces changements dans la BD
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');

ChangerMotPasse($_POST['numeroDA']);

function ChangerMotPasse($NumeroDA){
    try {
        $retour = ModifierMotPasse($NumeroDA, $NumeroDA);
        setParamChange($NumeroDA,0);
        echo $retour;
    }
    catch (PDOException $e)
    {
        echo 3;
    }
}

?>
