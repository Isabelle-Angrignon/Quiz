<?php
include("Utilitaires.php");
include("../Modele/ModeleEtudiants.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();

LireEtudiantDansUnCours($_POST['idCours'], $_SESSION['idUsager']);
