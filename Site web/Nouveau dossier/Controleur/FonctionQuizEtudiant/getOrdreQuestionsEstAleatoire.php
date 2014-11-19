<?php

////////////////////////////////////////////////////////////////////////////////////////////////////
// todo remplacer commentaires
//  getOrdreQuestionsEstAleatoire.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Récupère simplement une valeur d'une variable de session
//
//  POST:  aucun
//
//  Session :  'ordreQuestionsEstAleatoire' = int 1|0
//
//  Sortie :  int 1|0
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

//Récupère le paramètre de la session et le retourne
if (!empty($_SESSION['ordreQuestionsEstAleatoire']))
{
    echo $_SESSION['ordreQuestionsEstAleatoire'];
}
else
{
    echo 'Variable session sur l\'ordre des questions est non initialisée, voir admin.';
}