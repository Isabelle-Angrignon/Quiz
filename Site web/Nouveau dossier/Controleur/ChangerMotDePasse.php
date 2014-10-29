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
        $_SESSION['erreur'] = 'Certains champs sont vides';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    if(strlen($AncientMotPasse) > 16 || strlen($NouvMotPasse) > 16 || strlen($ConfNouvMotPasse) > 16)
    {
        $_SESSION['erreur'] = 'Les mots de passes sont limités à 16 caractères';
        header('Location: ../GererSonCompte.php');
        return 0;
    }

    if($AncientMotPasse == RecupererMotPasse($_SESSION['idUsager'])[0])
    {
        if ($NouvMotPasse == $ConfNouvMotPasse)
        {
            if($AncientMotPasse == $NouvMotPasse){

                $_SESSION['erreur'] = "Le nouveau mot de passe doit être différent de l'ancien";
                header('Location: ../GererSonCompte.php');
            }
            else
            {
                $retour = ModifierMotPasse($_SESSION['idUsager'], $NouvMotPasse);
                unset($_SESSION['erreur']);
                $_SESSION['reussite']= "Le mot de passe a été changé";
                setParamChange($_SESSION['idUsager'], true);
                $_SESSION['paramChange'] = 1;
                header('Location: ../GererSonCompte.php');
                echo $retour;
            }
        }
        else
        {
            $_SESSION['erreur'] = 'Les mots de passe ne sont pas identiques';
            header('Location: ../GererSonCompte.php');
        }
    }
    else
    {
        $_SESSION['erreur'] = 'Le mot de passe ne correspond pas à votre ancien mot de passe';
        header('Location: ../GererSonCompte.php');
    }
}

?>
