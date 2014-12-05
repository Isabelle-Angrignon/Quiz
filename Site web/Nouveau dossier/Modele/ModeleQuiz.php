<?php


// listerQuizSelonCoursProprietaire
// Par Mathieu Dumoulin
// Description : Cette fonction liste tous les quiz d'un cours selon son propriétaire.
//               Elle retourne un JSON pour simplifier la transition avec AJAX.
function listerQuizSelonCoursProprietaire($idCours, $idProprietaire)
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL listerQuizSelonCoursProprietaire(?,?)");

    $requete->bindParam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

function recupererInfoQuiz($idQuiz)
{
    $bdd = getConnection();

    if (isset($idQuiz))
    {
        $requete = $bdd->prepare("CALL recupererInfoQuiz( ? )");
        $requete->bindparam(1, $idQuiz, PDO::PARAM_INT,10);

        $requete->execute();
        $info = $requete->fetchAll();

        $requete->closeCursor();
        unset($bdd);
        
        return $info[0];
    }
    else{
        return null;
    }
}

function ajouterQuiz( $connexion, $titreQuiz, $ordreEstAleatoire, $idProprietaire ,$estDisponible)
{
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    // FORMATIF est hardcode pour l'instant car il n'y a pas d'autres types de quiz de créé.
    // Pour créé d'autres types de quiz, ajouter les éléments nécéssaires dans la page dynamique-GererQuiz au niveau de l'interface et prendre les
    // données dans la fonction ajouterQuiz du fichier Javascript/ProfGerer-Quiz.js
    $typeQuiz = "FORMATIF";

    $requete = $bdd->prepare("CALL ajouterQuiz(?,?,?,?,?)");

    $requete->bindParam(1, $titreQuiz, PDO::PARAM_STR);
    $requete->bindParam(2, $ordreEstAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(3, $typeQuiz, PDO::PARAM_STR);
    $requete->bindParam(4, $idProprietaire, PDO::PARAM_STR, 20);
    $requete->bindParam(5, $estDisponible, PDO::PARAM_INT,1);

    try
    {
        $requete->execute();

        $resultat = $requete->fetch();
    }
    catch(PDOException $e)
    {
        throw new ErrorException("Erreur dans l'ajout du quiz ayant comme titre : " . $titreQuiz);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }

    // [0] parce que la procédure stockée ne retourne qu'une seule donnée (le id du quiz ajouté)
    return $resultat[0];
}

function modifierQuiz( $connexion, $idQuiz, $titreQuiz, $ordreEstAleatoire, $idProprietaire ,$estDisponible)
{
    if(!isset($connexion))
    {
        $bdd = getConnection();
    }
    else
    {
        $bdd = $connexion;
    }

    // FORMATIF est hardcode pour l'instant car il n'y a pas d'autres types de quiz de créé.
    // Pour créé d'autres types de quiz, ajouter les éléments nécéssaires dans la page dynamique-GererQuiz au niveau de l'interface et prendre les
    // données dans la fonction ajouterQuiz du fichier Javascript/ProfGerer-Quiz.js
    $typeQuiz = "FORMATIF";

    $requete = $bdd->prepare("CALL modifierQuiz(?,?,?,?,?,?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);
    $requete->bindParam(2, $titreQuiz, PDO::PARAM_STR);
    $requete->bindParam(3, $ordreEstAleatoire, PDO::PARAM_INT,1);
    $requete->bindParam(4, $typeQuiz, PDO::PARAM_STR);
    $requete->bindParam(5, $idProprietaire, PDO::PARAM_STR, 20);
    $requete->bindParam(6, $estDisponible, PDO::PARAM_INT,1);

    try
    {
        $requete->execute();
    }
    catch(PDOException $e)
    {
        $requete->closeCursor();
        throw new ErrorException("Erreur dans la modification du quiz ayant comme titre : " . $titreQuiz);
    }

    $requete->closeCursor();

    if(!isset($connexion))
    {
        unset($bdd);
    }
}

function supprimerQuiz($idQuiz)
{
    $bdd = getConnection();

    $requete = $bdd->prepare("CALL supprimerQuiz(?)");

    $requete->bindParam(1, $idQuiz, PDO::PARAM_INT);

    $requete->execute();

    $requete->closeCursor();

    unset($bdd);
}

?>