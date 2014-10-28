<?php
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Prof');

CreerUsager($_POST['idUsager'], $_POST['nom'],$_POST['prenom']);

function CreerUsager($idEleve,$nom,$prenom)
{
    try {
        $retour = ajouterUsager($idEleve, $nom, $prenom);
        echo $retour;
    }
    catch (PDOException $e){
        echo 0;
    }
}
?>