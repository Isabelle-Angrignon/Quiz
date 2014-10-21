<?php

include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Usager');

ChangerMotPasse($_POST['AncienMotPasse'],$_POST['NouveauMotPasse'],$_POST['ConfNouveauMotPasse']);

function ChangerMotPasse($AncientMotPasse , $NouvMotPasse , $ConfNouvMotPasse){

    if($AncientMotPasse == '' || $NouvMotPasse == '' || $ConfNouvMotPasse == '')
    {
        $_SESSION['erreur'] = 'Certain champs sont vide';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    if(strlen($AncientMotPasse) > 16 || strlen($NouvMotPasse) > 16 || strlen($ConfNouvMotPasse) > 16)
    {
        $_SESSION['erreur'] = 'Les mots de passes sont limités a 16 caracteres';
        header('Location: ../GererSonCompte.php');
        return 0;
    }

    if($AncientMotPasse == RecupererMotPasse($_SESSION['idUsager'])[0])
    {
        if ($NouvMotPasse == $ConfNouvMotPasse)
        {
            ModifierMotPasse($_SESSION['idUsager'],$NouvMotPasse);
            $_SESSION['erreur'] = 'mot de passe changer avec succes';
            header('Location: ../GererSonCompte.php');
        }
        else
        {
            $_SESSION['erreur'] = 'Les mots de passes ne sont pas identiques';
            header('Location: ../GererSonCompte.php');
        }
    }
    else
    {
        $_SESSION['erreur'] = 'Le mot de passe ne coresspond pas a votre ancient mot de passe';
        header('Location: ../GererSonCompte.php');
    }
}

?>
