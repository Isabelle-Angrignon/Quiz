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
    $bdd = connecterEtudiant();

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

?>