<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$idReponse =  $_POST['idReponse'];
$idQuestion = $_SESSION['infoQuestion'][0]['idQuestion'];////// pourrait prende  [0]  au milieu


switch( $_SESSION['infoQuestion'][0]['typeQuestion']){
    case "VRAI_FAUX":
        if($_SESSION['listeReponses'][0]['reponseEstVrai'] == $idReponse)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
        break;
    case "CHOIX_MULTI_UNIQUE":
        //trouver la bonne réponse...
        foreach($_SESSION['listeReponses'] as $reponse)
        {
            if($reponse['reponseEstValide']  == 1 )
            {
                $bonneRep = $reponse['idReponse'];
            }
        }


        if($bonneRep == $idReponse)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
        break;
    default:
        echo "x";
        break;

}

?>