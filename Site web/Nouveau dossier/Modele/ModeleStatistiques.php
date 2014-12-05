<?php


function miseAJourStatsQuestion($idEtudiant, $idQuestion , $idQuiz, $estBon)
{

    $bdd = getConnection();
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


function obtenirStat()
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL ListerStats()");
    $requete->execute();
    $resultat = $requete->fetchAll();

    $requete->closeCursor();
    unset($bdd);

    return $resultat;
}

?>