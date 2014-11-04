<?php

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
