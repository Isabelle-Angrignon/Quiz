<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  verifierSiQuizTermine.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Vérifie s'il reste des questions da la liste de question du quiz en cours
//
//  Session :  'listeQuestions' = liste de idQuestions pour le quiz en cours
//
//  Sortie :  int 1|0
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

// cette variable de session contient une liste de idQuestions pour le quiz en cours
if (!empty($_SESSION['listeQuestions']))
{
    echo '0';
}
else
{

    echo '1';
}