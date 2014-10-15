<?php
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();

CreerEtudiant($_POST['idUsager'], $_POST['nom'],$_POST['prenom']);

function CreerEtudiant($idEleve,$nom,$prenom)
{
    ajouterUsager($idEleve,$nom,$prenom);
}
?>