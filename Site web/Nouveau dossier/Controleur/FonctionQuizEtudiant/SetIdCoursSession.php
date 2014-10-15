<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte();

$_SESSION['idCours'] = $_POST['selectCours'];

