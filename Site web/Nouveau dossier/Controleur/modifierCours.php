<?php
include("Utilitaires.php");
include("../Modele/ModeleCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Admin');
ModifierCours($_POST['idCours'],$_POST['nomCours'],$_POST['codeCours']);
?>