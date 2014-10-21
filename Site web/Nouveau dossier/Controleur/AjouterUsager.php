<?php
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');

CreerUsager($_POST['idUsager'], $_POST['nom'],$_POST['prenom']);

function CreerUsager($idEleve,$nom,$prenom)
{
    ajouterUsager($idEleve,$nom,$prenom);
}
?>