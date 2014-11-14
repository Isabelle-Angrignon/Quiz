<?php

include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleAssociationQuizQuestions.php");

if(isset($_POST['tableauQuestionsDansQuiz']))
{
    $tableauQuestionsDansQuiz = $_POST['tableauQuestionsDansQuiz'];

    foreach($tableauQuestionsDansQuiz[1]['questions'] as $question)
    {
        changerOrdreQuizQuestion($tableauQuestionsDansQuiz[0]['idQuiz'],$question['idQuestion'], $question['positionQuestion']);
    }
}
else
{
    echo "Erreur dans les paramètres passés lors de la modification de position d'une question dans un quiz.";
}