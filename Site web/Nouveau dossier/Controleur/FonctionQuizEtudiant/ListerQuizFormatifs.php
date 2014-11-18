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



