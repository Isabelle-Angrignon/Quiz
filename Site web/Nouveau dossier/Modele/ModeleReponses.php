<?php

// recupererReponsesQuestion
// Par: Mathieu Dumoulin
// Date: 13/10/2014
// Description: Cette fonction retourne toutes les réponses liés à une question. Si cette question est un vrai ou faux, il n'y aura aucune réponse car
//              les réponses de questions de type vrai/faux sont contenues dans la fonction recupererReponsesVraiFaux
function recupererReponsesAQuestion($idQuestion)
{
    $bdd = getConnection();

    if (isset($idQuestion))
    {
        $requete = $bdd->prepare("CALL recupererReponsesAQuestion(?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);

        $requete->execute();

        $reponses = $requete->fetchAll();
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd
    return $reponses;
}

// recupererReponsesVraiFaux
// Par: Mathieu Dumoulin
// Date: 13/10/2014
// Description: Cette fonction retourne toutes les réponses liés à une question de type Vrai/Faux
function recupererReponsesVraiFaux($idQuestion)
{
    $bdd = getConnection();

    if (isset($idQuestion))
    {
        $requete = $bdd->prepare("CALL recupererReponsesVraiFaux(?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);

        $requete->execute();

        $reponses = $requete->fetchAll();
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd
    return $reponses;
}

// ajouterReponse
// Par: Mathieu Dumoulin
// Date: 21/10/2014
// Description: Cette fonction ajoute une réponse dans la base de données
function ajouterReponse($connexion, $enonceReponse, $imageReponse,$idQuestion, $estValide, $positionReponse)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL ajouterReponse(?,?,?,?,?)");

    $requete->bindParam(1, $enonceReponse, PDO::PARAM_STR);
    $requete->bindParam(2, $imageReponse, PDO::PARAM_STR, 100);
    $requete->bindParam(3, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(4, $estValide, PDO::PARAM_INT);
    $requete->bindParam(5, $positionReponse, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans l'ajout de la réponse ayant comme énoncé : " . $enonceReponse);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function modifierReponse($connexion, $idReponse, $enonceReponse,$imageReponse, $estValide, $positionReponse)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL modifierReponse(?,?,?,?,?)");

    $requete->bindParam(1, $idReponse, PDO::PARAM_INT);
    $requete->bindParam(2, $enonceReponse, PDO::PARAM_STR);
    $requete->bindParam(3, $imageReponse, PDO::PARAM_STR, 100);
    $requete->bindParam(4, $estValide, PDO::PARAM_INT);
    $requete->bindParam(5, $positionReponse, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la modification de la réponse ayant comme énoncé : " . $enonceReponse);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function supprimerReponse($connexion, $idReponse)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL supprimerReponse(?)");

    $requete->bindParam(1, $idReponse, PDO::PARAM_INT);


    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la suppression de la réponse ayant comme identifiant : " . $idReponse );
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}