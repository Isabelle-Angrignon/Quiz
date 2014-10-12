<?php
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte();

ChangerEmail($_POST['Email'],$_POST['ConfirmationEmail']);

function ChangerEmail($ChainePremier , $ChaineDeuxieme)
{

    if($ChainePremier == '' || $ChaineDeuxieme == '')
    {
        $_SESSION['erreur'] = 'Certain champs sont vide';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    if(strlen($ChainePremier) > 255 || strlen($ChaineDeuxieme) > 255)
    {
        $_SESSION['erreur'] = 'Les adresses courriels sont limités a 255 caracteres';
        header('Location: ../GererSonCompte.php');
        return 0;
    }

    if ($ChainePremier == $ChaineDeuxieme )
    {
        if(filter_var($ChainePremier, FILTER_VALIDATE_EMAIL))
        {
            ModifierAdresseEmail($_SESSION['idUsager'], $ChainePremier);
            $_SESSION['erreur'] = 'adresse e-mail changer avec succes';
            header('Location: ../GererSonCompte.php');
            //redirigerSiDejaConnecte();
        }
        else
        {
            $_SESSION['erreur'] = "L'adresse e-mai n'est pas valide";
            header('Location: ../GererSonCompte.php');

        }
    }
    else
    {
        $_SESSION['erreur'] = 'Les champs de e-mail ne sont pas identiques';
        header('Location: ../GererSonCompte.php');
    }
}


?>