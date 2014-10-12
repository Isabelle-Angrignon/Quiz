<?php
include("Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte();

ChangerEmail($_POST['Email'],$_POST['ConfirmationEmail']);

function ChangerEmail($ChainePremier , $ChaineDeuxieme)
{
    if ($ChainePremier == $ChaineDeuxieme )
    {
        if(filter_var($ChainePremier, FILTER_VALIDATE_EMAIL))
        {
            echo 'sa marche' . ' //////////// ' . $ChainePremier;
        }
        else
        {
            $_SESSION['erreur'] = "L'adresse e-mai n'est pas valide";
           // header('Location: GererSonCompte.php');
            echo $_SESSION['erreur'] ;
        }
    }
    else
    {
        $_SESSION['erreur'] = 'Les champs de e-mail ne sont pas identiques';
        //header('Location: GererSonCompte.php');
        echo $_SESSION['erreur'];
    }
}


?>