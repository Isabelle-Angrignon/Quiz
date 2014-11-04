<?php
include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

//valide que la dernière question a été chargé dans la page
if (empty($_SESSION['listeQuestions']))
{
    echo '1';
}
else
{
    echo '0';
}