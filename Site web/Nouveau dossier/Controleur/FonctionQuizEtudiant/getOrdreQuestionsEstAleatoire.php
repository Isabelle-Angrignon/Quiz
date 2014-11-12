<?php
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