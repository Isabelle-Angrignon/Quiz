<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ChercherUsager.php
//  Fait pas : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier répondant a un appel ajax de type post afin de retourner si un usager existe par rapport a un numero de DA envoyer
//  par le ajax. Par la suite le fichier retourne soit un json contenant echec => vrai si l'usager n'existe pas ou le nom , prenom
//  de l'usager tel que écrit dans la BD sous format JSon
//
//  Retour : si Réussit => JSON - L'usager recherché (nom,prenom)
//                        JSON - Information de l'échec ( echec => vrai )
//
//  Parametre Post : idUsager = l'id de l'usager que l'on souhaite trouver
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Usager');
if( isset($_POST['idUsager']))
{
    $retour = ChercherUsager($_POST['idUsager']);
    if($retour == null){
        echo json_encode(array("echec" => "vrai"));
    }
    else{
        echo json_encode($retour);
    }
}
?>