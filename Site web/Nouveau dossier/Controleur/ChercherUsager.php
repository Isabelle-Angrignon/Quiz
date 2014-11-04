<?php
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