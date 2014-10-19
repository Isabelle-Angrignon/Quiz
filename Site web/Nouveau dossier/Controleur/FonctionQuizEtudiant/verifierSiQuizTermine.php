<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte();

if (!empty($_SESSION['listeQuestions']))
{
    echo '0';
}
else
{
    echo '1';
}