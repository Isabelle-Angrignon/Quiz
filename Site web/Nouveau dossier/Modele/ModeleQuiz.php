<?php

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