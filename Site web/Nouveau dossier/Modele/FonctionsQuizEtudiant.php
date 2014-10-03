<?php
/**
 * Created by PhpStorm.
 * User: Isabelle
 * Date: 2014-09-30
 * Time: 13:03
 */
function genererQuestionsAleatoires($cours)
{
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
            $_SESSION['listeQuestionsAleatoires'] = $quizAleatoire;
            echo 'Quiz généré.';
        }
        $requete->closeCursor();
    }

    unset($bdd);// fermer connection bd
}

/*
    Nom: LireCoursEtudiant
    Par: Simon Bouchard, adapté par Isabelle Angrignon
    Date: 03/10/2014
    Intrants: $idEtudiant = Le id d'un étudiant
    Extrant(s): Tableau de cours: idCours, codeCours, nomCours, idProfesseur
    Description: Cette fonction communique à la BD et récupère La liste des cours auquel cet étudiant est inscrit
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

function ListerQuizDansUl($idUl, $idEtudiant, $idCours, $typeQuiz)
{
    $Donnee = ListerQuizEtudiantCours($idEtudiant, $idCours, $typeQuiz );
    foreach($Donnee as $Row)
    {
        GenererLi($idUl,$Row['titrequiz'], $Row['idQuiz']);
    }
}

?>