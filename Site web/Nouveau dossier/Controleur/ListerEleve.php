<?php
include("Utilitaires.php");
include("../Modele/ModeleEtudiants.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();
$result =  json_encode(LireEtudiant());

echo $result;

?>
