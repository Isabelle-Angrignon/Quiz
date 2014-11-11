<?php


// listerQuizSelonCoursProprietaire
// Par Mathieu Dumoulin
// Description : Cette fonction liste tous les quiz d'un cours selon son propriétaire.
//               Elle retourne un JSON pour simplifier la transition avec AJAX.
function listerQuizSelonCoursProprietaire($idCours, $idProprietaire)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL listerQuizSelonCoursProprietaire(?,?)");

    $requete->bindParam(1, $idCours, PDO::PARAM_INT,10);
    $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);

    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return json_encode($resultat);
}

function recupererTypeQuiz($idQuiz)
{
    $bdd = connecterEtudiant();

    if (isset($idQuiz))
    {
        $requete = $bdd->prepare("CALL recupererTypeQuiz( ? )");
        $requete->bindparam(1, $idQuiz, PDO::PARAM_INT,10);


        $requete->execute();

        $type = $requete->fetch();

        $requete->closeCursor();
        unset($bdd);

        return $type[0];
    }
    else{
        return null;
    }
}

?>