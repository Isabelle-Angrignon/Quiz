<?php
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$resultat = json_encode(LireCours());
echo $resultat;
?>