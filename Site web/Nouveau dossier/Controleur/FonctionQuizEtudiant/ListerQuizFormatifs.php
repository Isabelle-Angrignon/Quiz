<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListerQuizFormatifs.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Génere et retourne la liste des quiz formatifs pour un cours spécifiques ou pour tous les cours de l'étudiant
//
//  POST: aucun, tout vient des variables de session
//
//  Session :  'idCours' et "idUsager"
//
//  Sortie :  un json  qui contient la liste des quiz comportant au moins le idQuiz et le titre de chaque quiz.
//            Voir méthodes appelées pour plus de détails
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("..//Utilitaires.php");
include("..//..//Modele/ModeleUtilisateurs.php");
include("..//..//Modele/ModeleUsagers.php");
include("..//..//Modele/mFonctionsQuizEtudiant.php");

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


