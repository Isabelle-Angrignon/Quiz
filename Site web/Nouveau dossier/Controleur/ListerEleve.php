<?php
include("Utilitaires.php");
include("../Modele/ModeleEtudiants.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  json_encode(LireEtudiant());

echo $result;

?>
