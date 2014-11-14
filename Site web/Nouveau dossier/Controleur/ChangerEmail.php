<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ChangerEmail.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Ce fichier change le e-mail d'un usager suite a un appel de type post par la suite il redirige vers la page
//  GérerCompte.php en insérant une érreur si il y'en a eu dans la variable de session erreur
//
//  Parametre en post :
//  Email = nouveau Email désiré , ConfirmationEmail = Confirmation de l'usager du Email
//
//  Session : Utilisation de l'idUsager pour savoir qui qui souhaite modifier son compte
//
//  Redirection : GererCompte.php
//
////////////////////////////////////////////////////////////////////////////////////////////////////
include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Usager');

ChangerEmail($_POST['Email'],$_POST['ConfirmationEmail']);

function ChangerEmail($ChainePremier , $ChaineDeuxieme)
{
    // Si l'un des champs est vide
    if($ChainePremier == '' || $ChaineDeuxieme == '')
    {
        $_SESSION['erreur'] = 'Certain champs sont vide';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    // Si l'un des champs est trop long
    if(strlen($ChainePremier) > 255 || strlen($ChaineDeuxieme) > 255)
    {
        $_SESSION['erreur'] = 'Les adresses courriels sont limités a 255 caracteres';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    // Si les deux champs sont identiques
    if ($ChainePremier == $ChaineDeuxieme )
    {
        // Si le E-mail possède un format valide
        if(filter_var($ChainePremier, FILTER_VALIDATE_EMAIL))
        {
            ModifierAdresseEmail($_SESSION['idUsager'], $ChainePremier);
            unset($_SESSION['erreur']);
            $_SESSION['reussite'] = "L'adresse Courriel a été changé";
            header('Location: ../GererSonCompte.php');
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