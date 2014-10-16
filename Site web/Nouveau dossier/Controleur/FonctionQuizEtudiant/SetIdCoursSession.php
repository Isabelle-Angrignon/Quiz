<?php

include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte();

$_SESSION['idCours'] = $_POST['selectCours'];

resetVarSessionQuiz();

