<?php
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  desinscrireEtudiantCours($_POST['idE'],$_POST['idCours'], $_SESSION['idUsager']);


?>
