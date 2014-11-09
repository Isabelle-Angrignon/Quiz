<?php


function miseAJourStatsQuestion($idEtudiant, $idQuestion , $idQuiz, $estBon)
{
    $bdd = connecterEtudiant();
    if (isset($idEtudiant) AND isset($idQuestion) AND isset($idQuiz)  AND isset($estBon))
    {
        $requete = $bdd->prepare("CALL miseAJourStats(?, ?, ? , ?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);
        $requete->bindparam(2, $idEtudiant, PDO::PARAM_STR,10);
        $requete->bindparam(3, $idQuiz, PDO::PARAM_INT,10);
        $requete->bindparam(4, $estBon, PDO::PARAM_INT,10);

        $requete->execute();

        $requete->closeCursor();
        unset($bdd);

    }
    else{
        echo "Un parametre n'a pas de valeur";
    }
}

//à partir des variables de session...
function miseAJourStatsQuiz()
{
    $idQuiz = $_SESSION['idQuiz'];
    $idEtudiant = $_SESSION['idUsager'];

    if (isset($_SESSION['listeQuestionRepondues']) AND isset($_SESSION['bienRepondu']) )
    {
        $listeQuestions = $_SESSION['listeQuestionRepondues'];
        $listeResultats =  $_SESSION['bienRepondu'];

        if(count($listeQuestions) == count($listeResultats))
        {
            //passer chaques éléments de quaque liste dans la miseAJourStats
            while (count($listeQuestions) >= 1)
            {
                $question = array_shift($listeQuestions);
                $resultat = array_shift($listeResultats);

                miseAJourStatsQuestion($idEtudiant, $question, $idQuiz, $resultat );
            }
            echo "Les statistiques on été mises à jour. ";
        }
        else
        {
            echo "oups, problème à la compilation des résultats...";
        }
    }
    else{
        echo "Pas de questions répondues";
    }
}

?>