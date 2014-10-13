<?php
include("Utilitaires.php");
include("../Modele/ModeleEtudiants.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();
$result =  LireEtudiantDansUnCours($_POST['idCours'], $_SESSION['idUsager']);

echo $result;

?>
