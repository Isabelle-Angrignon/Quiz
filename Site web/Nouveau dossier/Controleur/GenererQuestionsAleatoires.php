<?php
include("..//Modele/mFonctionsQuizEtudiant.php");

$cours = $_POST['DDL_Cours'];

genererQuestionsAleatoires($cours);

//send_redirect("")

?>