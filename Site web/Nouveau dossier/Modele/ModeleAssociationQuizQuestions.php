<?php

 function lierQuizQuestion($idQuiz, $idQuestion, $positionQuestion)
 {
     $bdd = connecterProf();
     $requete = $bdd->prepare("CALL associerQuestionQuiz(?,?,?)");

     $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
     $requete->bindParam(2, $idQuiz, PDO::PARAM_INT);
     $requete->bindParam(3, $positionQuestion, PDO::PARAM_INT);

     $requete->execute();

     $requete->closeCursor();
     unset($bdd);
 }

function supprimerLienQuizQuestion($idQuiz, $idQuestion)
{
    $bdd = connecterProf();
    $requete = $bdd->prepare("CALL supprimerLienQuestionQuiz(?,?)");

    $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
    $requete->bindParam(2, $idQuiz, PDO::PARAM_INT);

    $requete->execute();

    $requete->closeCursor();
    unset($bdd);
}

 function changerOrdreQuizQuestion($idQuiz, $idQuestion, $positionQuestion)
 {
     $bdd = connecterProf();
     $requete = $bdd->prepare("CALL changerOrdreQuestionQuiz(?,?,?)");

     $requete->bindParam(1, $idQuestion, PDO::PARAM_INT);
     $requete->bindParam(2, $idQuiz, PDO::PARAM_INT);
     $requete->bindParam(3, $positionQuestion, PDO::PARAM_INT);

     $requete->execute();

     $requete->closeCursor();
     unset($bdd);
 }