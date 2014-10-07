<?php
/*
    Nom: genererQuestionsAleatoires
    Par: Isabelle Angrignon
    Date: 03/10/2014
    Description: Cette fonction communique à la BD et récupère La liste des questions de type aléatoire
                pour un cours donné.
*/
function genererQuestionsAleatoires()
{
    $cours = $_POST['DDL_Cours'];

    // a retirer et mettre connecterEtudiant
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');

    if (isset($cours))
    {
        $requete = $bdd->prepare("CALL genererQuestionsAleatoires(?)");
        $requete->bindparam(1, $cours, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $requete->execute();
        }
        $quizAleatoire = $requete->fetchAll();

        if (!empty($quizAleatoire))
        {
            $_SESSION['listeQuestionsAleatoires'] = shuffle($quizAleatoire);
        }
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd


}

/*
    Nom: recupererElementsQuestion
    Par: Isabelle Angrignon
    Date: 04/10/2014
    Description: Cette fonction communique à la BD et récupère Les informations pertinentes
                a une question.
*/
function recupererElementsQuestion($idQuestion)
{
    // a retirer et mettre connecterEtudiant
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');

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

    return $infosQuestion;
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
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
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

?>