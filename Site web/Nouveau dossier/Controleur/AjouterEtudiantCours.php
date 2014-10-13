<?php
include("Utilitaires.php");
include("../Modele/ModeleInscriptionsEtudiantCours.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();
$result =  InscrireEtudiantCours($_POST['idE'],$_POST['nom'],$_POST['prenom'],$_POST['idCours'], $_SESSION['idUsager']);
echo $_POST['idE'] . $_POST['nom'] . $_POST['prenom'] . $_POST['idCours'];
//$result = InscrireEtudiantCours('200049000','Laracque','Georges',1, '420yacoub');


?>
