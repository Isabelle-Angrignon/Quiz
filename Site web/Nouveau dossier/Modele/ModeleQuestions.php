<?php


/*
    Nom: recupererElementsQuestion
    Par: Isabelle Angrignon
    Date: 04/10/2014
    Description: Cette fonction communique à la BD et récupère Les informations pertinentes
                a une question.
*/
function recupererElementsQuestion($idQuestion)
{

    $bdd = getConnection("etudiant"); ////////////////// À modifier avec la session et le typeUsager de la session /////////////////////////////////////////

    if (isset($idQuestion))
    {
        $requete = $bdd->prepare("CALL recupererElementsQuestion(?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $requete->execute();
        }
        $infosQuestion = $requete->fetchAll();
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd

    if (isset($infosQuestion))
    {
        return $infosQuestion;
    }
    else
    {
        return null;
    }
}

// Nom: prendreListeQuestion
// Par: Mathieu Dumoulin
// Intrants: $idCours = identifiant du cours en question. $idProprietaire = identifiant du professeur en question
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions()
function trieParDefaultQuestions($idCours, $idProprietaire)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerQuestions(?,?)");

    $requete->bindParam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

// Nom: ajouterQuestion
// Par: Mathieu Dumoulin
// Date: 15/10/2014
// Description: Cette fonction ajoute une question dans la base de données. Si la connexion passée en paramètre est null, cette fonction va créer et fermer sa propre connexion.
function ajouterQuestion($connexion, $enonceQuestion, $lienImage, $difficulte, $ordreReponsesAleatoire, $typeQuestion, $idProprietaire, $referenceWeb)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL ajouterQuestion(?,?,?,?,?,?,?)");

    $requete->bindParam(1, $enonceQuestion, PDO::PARAM_STR);
    $requete->bindParam(2, $lienImage, PDO::PARAM_STR, 100);
    $requete->bindParam(3, $difficulte, PDO::PARAM_STR, 20);
    $requete->bindParam(4, $ordreReponsesAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(5, $typeQuestion, PDO::PARAM_STR, 30);
    $requete->bindParam(6, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(7, $referenceWeb, PDO::PARAM_STR);

    try
    {
        $requete->execute();

        $resultat = $requete->fetch();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans l'ajout de la question ayant comme énoncé : " . $enonceQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }

    return $resultat;
}


function modifierQuestion($connexion, $idQuestion,$enonceQuestion, $lienImage, $difficulte, $ordreReponsesAleatoire, $typeQuestion, $idProprietaire, $referenceWeb)
{
    if(!isset($connexion))
    {
        $bdd = connecterProf();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL modifierQuestion(?,?,?,?,?,?,?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $enonceQuestion, PDO::PARAM_STR);
    $requete->bindParam(3, $lienImage, PDO::PARAM_STR, 100);
    $requete->bindParam(4, $difficulte, PDO::PARAM_STR, 20);
    $requete->bindParam(5, $ordreReponsesAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(6, $typeQuestion, PDO::PARAM_STR, 30);
    $requete->bindParam(7, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(8, $referenceWeb, PDO::PARAM_STR);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans la modification de la question ayant comme énoncé : " . $enonceQuestion);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

?>