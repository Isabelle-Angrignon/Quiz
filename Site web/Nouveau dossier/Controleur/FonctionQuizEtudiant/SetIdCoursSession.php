<?php

include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

//on aura besoin du id de cours dans la gestion du quiz...
$_SESSION['idCours'] = $_POST['selectCours'];

//Remet a vide les variables de session reliées au quiz.
//Tel la liste des questionns et autres.
resetVarSessionQuiz();

if (isset($_SESSION['idCours'])) {
    if ($_SESSION['idCours'] == '0') {
        echo '0';// cours non selectionné
    } else {
        echo '1';
    }
}
else
{
    echo '<script>alert("Aucun cours dans la variable session! Consultez un administrateur")</script>';
}


