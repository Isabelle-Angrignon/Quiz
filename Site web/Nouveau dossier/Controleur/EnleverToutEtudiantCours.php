<?php
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');
$result =  desinscrireToutEtudiantCours($_POST['idCours'], $_SESSION['idUsager']);

//$result = InscrireEtudiantCours('200049000','Laracque','Georges',1, '420yacoub');


?>