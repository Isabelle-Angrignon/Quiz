<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ChangerDeMotDePasse.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Ce fichier change le mot de passe d'un usager suite a un appel de type post par la suite il redirige vers la page
//  GérerCompte.php en insérant une érreur si il y'en a eu dans la variable de session erreur
//
//  Parametre de post :
//  AncientMotPasse = L'ancien mot de passe de l'usager qu'il doit avoir confirmer ,
//  NouveauMotPasse = Le nouveau mot de passe souhaité par l'usager , ConfNouveauMotPasse = La confirmation de l'usager
//
//  Session :
//  idUsager pour savoir quel usager souhaite changer son mot de passe
//
//  Redirection :
//  Vers la page gererCompte.php
//
////////////////////////////////////////////////////////////////////////////////////////////////////

include("Utilitaires.php");
include("../Modele/ModeleUsagers.php");
include("../Modele/ModeleUtilisateurs.php");
demarrerSession();
redirigerSiNonConnecte('Usager');

ChangerMotPasse($_POST['AncienMotPasse'],$_POST['NouveauMotPasse'],$_POST['ConfNouveauMotPasse']);

function ChangerMotPasse($AncientMotPasse , $NouvMotPasse , $ConfNouvMotPasse){
    // Si l'un des champs est vide
    if($AncientMotPasse == '' || $NouvMotPasse == '' || $ConfNouvMotPasse == '')
    {
        $_SESSION['erreur'] = 'Certains champs sont vides';
        header('Location: ../GererSonCompte.php');
        return 0;
    }
    // Si l'un des champs est trop long
    if(strlen($AncientMotPasse) > 16 || strlen($NouvMotPasse) > 16 || strlen($ConfNouvMotPasse) > 16)
    {
        $_SESSION['erreur'] = 'Les mots de passes sont limités à 16 caractères';
        header('Location: ../GererSonCompte.php');
        return 0;
    }

    // Si l'ancient mot de passe n'est pas bon
    echo password_verify($AncientMotPasse, RecupererMotPasse($_SESSION['idUsager'])[0]);
    echo RecupererMotPasse($_SESSION['idUsager'])[0];
    echo "    //////////////////////    ";
    echo password_hash($AncientMotPasse,PASSWORD_BCRYPT);
    if((password_verify($AncientMotPasse, RecupererMotPasse($_SESSION['idUsager'])[0])))
    {
        // Si la confirmation du mot de passe n'est pas identique au mot de passe souhaié
        if ($NouvMotPasse == $ConfNouvMotPasse)
        {
            // Si l'ancient mot de passe est pareil au nouveau
            if($AncientMotPasse == $NouvMotPasse){

                $_SESSION['erreur'] = "Le nouveau mot de passe doit être différent de l'ancien";
                header('Location: ../GererSonCompte.php');
            }
            else
            {
                $MDPCrypter = password_hash($NouvMotPasse,PASSWORD_BCRYPT);
                $retour = ModifierMotPasse($_SESSION['idUsager'], $MDPCrypter);
                unset($_SESSION['erreur']);
                $_SESSION['reussite']= "Le mot de passe a été changé";
                setParamChange($_SESSION['idUsager'], true);
                $_SESSION['paramChange'] = 1;
                header('Location: ../GererSonCompte.php');

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
