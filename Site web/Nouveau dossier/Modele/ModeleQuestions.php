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

    $bdd = getConnection();

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

// Nom: trieParDefaultQuestions
// Par: Mathieu Dumoulin
// Intrants: $idCours = identifiant du cours en question. $idProprietaire = identifiant du professeur en question
//           $filtreEnonce (recherche si contient l'expression) et $filtreId (recherche id exacte), pour filtrer les questions
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions()
function trieParDefaultQuestions($idCours, $idProprietaire, $filtreEnonce, $filtreId)
{

    $filtreEnonce = '%'.$filtreEnonce.'%';
    $filtreId==""?$filtreId=0:$filtreId=$filtreId;
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerQuestions(?,?,?,?)");

    $requete->bindParam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(3, $filtreEnonce, PDO::PARAM_STR, 32);
    $requete->bindParam(4, $filtreId, PDO::PARAM_INT,10);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

// Nom: listerQuestionsDunQuiz
// Par: Mathieu Dumoulin
// Intrants: $idQuiz = identifiant du quiz qui contient les questions voulues. $idProprietaire = identifiant du professeur en question
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestionsSelonQuiz()
function listerQuestionsDunQuiz($idQuiz, $idProprietaire)
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerQuestionsSelonQuiz(?,?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

// Nom: listerQuestionsPasDansCeQuiz
// Par: Mathieu Dumoulin
// Intrants: $idQuiz = identifiant du quiz qui contient les questions voulues. $idProprietaire = identifiant du professeur en question
//           $idCours = identifiant du cours qui est sélectionné dans la DDL.  $typeQuiz = type du quiz qui est présentement en cours de modification
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestionsSelonQuiz()
function listerQuestionsPasDansCeQuiz($idQuiz, $idProprietaire, $idCours, $typeQuiz, $filtreEnonce, $filtreId)
{
    $filtreEnonce = @'%'.$filtreEnonce.'%';
    $filtreId==""?$filtreId=0:$filtreId=$filtreId;
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerQuestionsPasDansQuiz(?,?,?,?,?,?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(3, $idCours, PDO::PARAM_INT);
    $requete->bindParam(4, $typeQuiz, PDO::PARAM_STR,20);
    $requete->bindParam(5, $filtreEnonce, PDO::PARAM_STR, 32);
    $requete->bindParam(6, $filtreId, PDO::PARAM_INT,10);

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
function ajouterQuestion($connexion, $enonceQuestion, $lienImage, $difficulte, $ordreReponsesAleatoire, $typeQuestion, $idProprietaire, $referenceWeb, $estDisponible)
{
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL ajouterQuestion(?,?,?,?,?,?,?,?)");

    $requete->bindParam(1, $enonceQuestion, PDO::PARAM_STR);
    $requete->bindParam(2, $lienImage, PDO::PARAM_STR, 100);
    $requete->bindParam(3, $difficulte, PDO::PARAM_STR, 20);
    $requete->bindParam(4, $ordreReponsesAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(5, $typeQuestion, PDO::PARAM_STR, 30);
    $requete->bindParam(6, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(7, $referenceWeb, PDO::PARAM_STR);
    $requete->bindParam(8, $estDisponible, PDO::PARAM_INT,1);

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


function modifierQuestion($connexion, $idQuestion,$enonceQuestion, $lienImage, $difficulte, $ordreReponsesAleatoire, $typeQuestion, $idProprietaire, $referenceWeb, $estDiponible)
{
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    $requete = $bdd->prepare("CALL modifierQuestion(?,?,?,?,?,?,?,?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $enonceQuestion, PDO::PARAM_STR);
    $requete->bindParam(3, $lienImage, PDO::PARAM_STR, 100);
    $requete->bindParam(4, $difficulte, PDO::PARAM_STR, 20);
    $requete->bindParam(5, $ordreReponsesAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(6, $typeQuestion, PDO::PARAM_STR, 30);
    $requete->bindParam(7, $idProprietaire, PDO::PARAM_STR, 10);
    $requete->bindParam(8, $referenceWeb, PDO::PARAM_STR);
    $requete->bindParam(9, $estDiponible, PDO::PARAM_INT,1);

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

function supprimerQuestion($idQuestion)
{
    $bdd = getConnection();

    $requete = $bdd->prepare("CALL supprimerQuestion(?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        echo "Erreur dans la suppression de la question : " . $idQuestion;
    }

    $requete->closeCursor();
    unset($bdd);
}

?>