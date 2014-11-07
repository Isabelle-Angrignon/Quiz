<?php

include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

//on aura besoin du id de quiz dans la mise a jour des stats quiz...

$_SESSION['idQuiz'] = $_POST['selectQuiz'];

//Remet a vide les variables de session reliées au quiz.
//Tel la liste des questions et autres.
resetVarSessionQuiz();




