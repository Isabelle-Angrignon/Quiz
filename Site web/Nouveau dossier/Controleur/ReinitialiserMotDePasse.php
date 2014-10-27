<?php

include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');

ChangerMotPasse($_POST['numeroDA']);

function ChangerMotPasse($NumeroDA){
    try {
        ModifierMotPasse($NumeroDA, $NumeroDA);
        setParamChange($NumeroDA,0);
        echo 0;
    }
    catch (PDOException $e)
    {
        echo 1;
    }
}

?>
