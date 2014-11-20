<?php
include("Utilitaires.php");
demarrerSession();

$clee = $_POST['clee'];
$valeur = $_POST['valeur'];

$_SESSION[$clee] = $valeur;

echo 'Bien passer';