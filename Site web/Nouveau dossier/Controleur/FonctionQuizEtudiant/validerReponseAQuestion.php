<?php

include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$idReponse =  $_POST['idReponse'];
$idQuestion = $_SESSION['infoQuestion'][0]['idQuestion'];//meme si il n'y a g'un enregistrement dans infoQuestion, il faut spécifier [0]


switch( $_SESSION['infoQuestion'][0]['typeQuestion']){

    case "VRAI_FAUX":
        echo gererReponse($_SESSION['listeReponses'][0]['reponseEstVrai'] == $idReponse);
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

        echo gererReponse($bonneRep == $idReponse);
        break;

    //ajouter autres types de questions ici

    default:
        echo "x";
        break;
}

?>