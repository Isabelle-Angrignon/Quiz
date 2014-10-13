<?php
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();
$result =  desinscrireEtudiantCours($_POST['idE'],$_POST['idCours'], $_SESSION['idUsager']);

//$result = InscrireEtudiantCours('200049000','Laracque','Georges',1, '420yacoub');


?>
