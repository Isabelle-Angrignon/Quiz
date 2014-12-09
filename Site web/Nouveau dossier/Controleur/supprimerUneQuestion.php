<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  SupprimerUnCompte.php
//  Fait par : Mathieu Dumoulin
//  Commenter le : 12/11/2014
//
//  Description :
//  Ce fichier répond a un appel Ajax de type post afin de supprimer une réponse
//
//  Paramètre de Post: idQuestion = l'id de la question a supprimer
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuestions.php");
session_start();

if(isset($_POST['idQuestion']))
{
    supprimerQuestion($_POST['idQuestion']);
}
else
{
    echo "Le id n'est pas set";
}
