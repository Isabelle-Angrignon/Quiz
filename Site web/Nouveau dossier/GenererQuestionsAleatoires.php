<!DOCTYPE html>
<html>


<?php
include("Vue/Template/InclusionJQuery.php");
include("Vue/Template/InclusionTemplate.php");

include("Controleur/cFonctionsCours.php");
include("Modele/ModeleCours.php");
include("Modele/mFonctionsQuizEtudiant.php");
include("Controleur/cFonctionsQuizEtudiant.php");

demarrerSession();
redirigerSiNonConnecte();

$cours = 3;//$_SESSION['idCours'];

//devra fair un switch case selon le type de quiz...
genererQuestionsAleatoires($cours);

header('Location: Etudiant-Accueil.php');
?>


</html>
