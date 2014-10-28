<?php

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
