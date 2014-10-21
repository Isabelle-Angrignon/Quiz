<?php
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  LireEtudiantDansUnCours($_POST['idCours'], $_SESSION['idUsager']);

echo $result;

?>
