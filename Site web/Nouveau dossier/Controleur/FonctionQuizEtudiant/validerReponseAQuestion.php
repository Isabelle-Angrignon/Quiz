<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte();

$idReponse =  $_POST['idReponse'];
$idQuestion = $_SESSION['infoQuestion']['idQuestion'];


switch( $_SESSION['infoQuestion']['typeQuestion']){
    case "VRAI-FAUX":
        if($_SESSION['listeReponses']['reponseEstVrai'] == $idReponse)
        {
            return "1";
        }
        else
        {
            return "0";
        }
        break;
    case "CHOIX_MULTI_UNIQUE":

        foreach($_SESSION['listeReponses'] as $reponse)
        {
            if($reponse['reponseEstValide']  == 1 )
            {
                $bonneRep = $reponse['idReponse'];
            }
        }
        if($bonneRep == $idReponse)
        {
            return "1";
        }
        else
        {
            return "0";
        }
        break;
    default:
        return "x";
        break;

}

?>