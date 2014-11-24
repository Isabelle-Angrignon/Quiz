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
    $bdd = getConnection($_SESSION['typeUsager']);

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
    unset($bdd);

    return null;
}

/*
    Nom: genererQuestionsQuiz
    Par: Isabelle Angrignon
    Description: Cette fonction communique à la BD et récupère La liste des questions pour un quiz donné.
                La liste est retournée.
*/
function genererQuestionsQuiz($idQuiz)
{
    $bdd = getConnection($_SESSION['typeUsager']);

    if (isset($idQuiz))
    {
        $requete = $bdd->prepare("CALL genererQuestionsQuiz(?)");
        $requete->bindparam(1, $idQuiz, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $requete->execute();
            $quiz = $requete->fetchAll();
        }

        if (isset($quiz)  && !empty($quiz))
        {
            return $quiz;
        }
        else
        {
            return null;
        }
        $requete->closeCursor();
    }
    unset($bdd);

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
    $bdd = getConnection($_SESSION['typeUsager']);
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
/*
    Nom: ListerQuizEtudiant
    Par: Isabelle Angrignon
    Description: Cette fonction communique à la BD et récupère La liste de tous les Quiz d'un type donné
                pour tous les cours auquel un étudiant est inscrit.
*/
function ListerQuizEtudiant($idEtudiant, $typeQuiz)
{
    $bdd = getConnection($_SESSION['typeUsager']);
    $requete = $bdd->prepare("CALL listerQuizEtudiant( ? , ? )");
    $requete->bindparam(1, $idEtudiant, PDO::PARAM_STR,10);
    $requete->bindparam(2, $typeQuiz, PDO::PARAM_STR,20);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

/*
    Nom: recupererCoursQuizEtudiant
    Par: Isabelle Angrignon
    Description: Cette fonction communique à la BD et récupère Le nom du cours auquel est inscrit l'étudiant et pour le
                quiz qu'il a choisi.
*/
function recupererCoursQuizEtudiant($idQuiz, $idEtudiant)
{
    $bdd = getConnection($_SESSION['typeUsager']);
    $requete = $bdd->prepare("CALL recupererCoursQuizEtudiant( ? , ? )");
    $requete->bindparam(1, $idQuiz, PDO::PARAM_INT,10);
    $requete->bindparam(2, $idEtudiant, PDO::PARAM_STR,10);
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}