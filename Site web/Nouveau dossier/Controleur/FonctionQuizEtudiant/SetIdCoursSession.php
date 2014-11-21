<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  SetIdCoursSession.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Met la variable identifiant le idCours passé en POST dans la variable de session pour réféerence future
//        Remet ensuite les variables de session liées au Quiz à "vide"
//
//  POST: 'selectCours' = le idCours
//
//  Session :  'idCours' : Le nom le dit
//
//  Sortie :  int 1|0 pour identifier si un cours est sélectionné ou non.  Le menu cours ayant l'item "Tous les cours"
//            en position "0".
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

//on aura besoin du id de cours dans la gestion du quiz...
$_SESSION['idCours'] = $_POST['selectCours'];
$_SESSION['posCoursDansListe'] = $_POST['posCoursDansListe'];


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


