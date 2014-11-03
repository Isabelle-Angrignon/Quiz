<?php


function afficherQuestionVraiFaux($idQuestion)
{
    $bdd = connecterProf();

    $requete = $bdd->prepare("CALL listerQuestionVraiFauxSelonQuestion(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    $requete->execute();

    $reponses = $requete->fetch();
    $requete->closeCursor();

    unset($bdd);// fermer connection bd
    return $reponses;
}


function ajouterLienQuestionsVraiFaux($connexion, $idQuestion, $estVrai)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL associerQuestionVraiFaux(?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $estVrai, PDO::PARAM_INT,1);


    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la liaison vrai/faux de la question ayant comme identifiant : " . $idQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function supprimerLienQuestionVraiFaux($connexion, $idQuestion)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL supprimerLienQuestionVraiFaux(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la suppression de la liaison vrai/faux de la question ayant comme identifiant : " . $idQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }

}