<?php 
	/*include("Vue/PHP de base/Utilitaires.php");	

	demarrerSession();
	redirigerSiNonConnecte();*/

	$nombreUn = $_POST['NombreUn'];
	$nombreDeux = $_POST['NombreDeux'];
	
	$resultat = $nombreUn + $nombreDeux;
	
	echo $resultat;
	
	die();
?>