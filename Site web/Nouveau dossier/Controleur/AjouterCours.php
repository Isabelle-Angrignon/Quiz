<?php
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
AjouterCours($_POST['nom'],$_POST['code']);

?>