<?php

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
