<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

if (!empty($_SESSION['listeQuestions']))
{
    echo '0';
}
else
{
    echo '1';
}