<?php

include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//..//Modele/mFonctionsQuizEtudiant.php");
/*
include("..//cFonctionsQuizEtudiant.php");
include("..//..//Modele/ModeleQuestions.php");*/
demarrerSession();
redirigerSiNonConnecte('Etudiant');


if ($_SESSION['idCours']==0)// signifie tous les cours
{
    $liste = json_encode(ListerQuizEtudiant($_SESSION["idUsager"], "FORMATIF"));

}
else
{
    $liste = json_encode(ListerQuizEtudiantCours($_SESSION["idUsager"], $_SESSION['idCours'], "FORMATIF"));
}

if (isset($liste) && $liste != "" )
{
    echo $liste;
}
else
{
    echo '<script>alert ("Pas de quiz!")</script>';
}



