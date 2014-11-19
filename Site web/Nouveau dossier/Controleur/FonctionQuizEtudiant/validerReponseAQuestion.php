<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  validerReponseAQuestion.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  But : Déterminer si une réponse donnée est la bonne réponse à la question posée selon le type de question
//        et ensuite gérer la réponse
//
//  POST: idReponse tel que la clé primaire de la table de la bs.  0|1 si c'est une question vrai ou faux
//
//  Session :  'infoQuestion' = array qui contient les attributs relatifs à la question: ce array contient
//              un seul enregistrement mais il faut quand même utiliser [0] pour lire les attributs de cet enregistrement.
//              'typeQuestion' = "VRAI_FAUX" , "CHOIX_MULTI_UNIQUE" ou autre, voir table typesQuestions pour connaître les autres types
//
//  Sortie :  int 1|0 selon bonne ou mauvaise réponse
//
////////////////////////////////////////////////////////////////////////////////////////////////////

include("..//Utilitaires.php");
include("..//cFonctionsQuizEtudiant.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

$idReponse =  $_POST['idReponse'];
$idQuestion = $_SESSION['infoQuestion'][0]['idQuestion'];//meme si il n'y a g'un enregistrement dans infoQuestion, il faut spécifier [0]


switch( $_SESSION['infoQuestion'][0]['typeQuestion']){

    case "VRAI_FAUX":
        echo gererReponse($_SESSION['listeReponses'][0]['reponseEstVrai'] == (int)$idReponse);//cast empeche injection de "id || true"
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

        echo gererReponse($bonneRep == (int)$idReponse);//cast empeche injection de "id || true"
        break;

    //ajouter autres types de questions ici

    default:
        echo "x";
        break;
}

?>