<?php
/*
    Nom: genererQuestionsAleatoires
    Par: Isabelle Angrignon
    Date: 03/10/2014
    Description: Cette fonction communique à la BD et récupère La liste des questions de type aléatoire
                pour un cours donné.  La liste est retournée.
*/
function genererQuestionsAleatoires($cours)
{
    $bdd = connecterEtudiant();

    if (isset($cours))
    {
        $requete = $bdd->prepare("CALL genererQuestionsAleatoires(?)");
        $requete->bindparam(1, $cours, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $requete->execute();
            $quizAleatoire = $requete->fetchAll();
        }

        if (isset($quizAleatoire)  && !empty($quizAleatoire))
        {
            return $quizAleatoire;
        }
        else
        {
            return null;
        }
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd

    return null;
}



/*
    Nom: ListerQuizEtudiantCours
    Par: Isabelle Angrignon
    Date: 03/10/2014
    Description: Cette fonction communique à la BD et récupère La liste des Quiz d'un type donné
                pour un cours donné auquel un étudiant est inscrit.
*/
function ListerQuizEtudiantCours($idEtudiant, $idCours, $typeQuiz)
{
    $bdd = connecterEtudiant();
    $requete = $bdd->prepare("CALL ListerQuizEtudiantCours( ? , ? , ? )");
    $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
    $requete->bindparam(2, $idCours, PDO::PARAM_INT,10);
    $requete->bindparam(3, $typeQuiz, PDO::PARAM_STR,20);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

function ListerQuizEtudiant($idEtudiant, $typeQuiz)
{
    $bdd = connecterEtudiant();
    $requete = $bdd->prepare("CALL listerQuizEtudiant( ? , ? )");
    $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
    $requete->bindparam(2, $typeQuiz, PDO::PARAM_STR,20);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}
