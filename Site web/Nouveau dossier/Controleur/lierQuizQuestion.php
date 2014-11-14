<?php

include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleAssociationQuizQuestions.php");

if(isset($_POST['idQuiz']) && isset($_POST['idQuestion']) && isset($_POST['positionQuestion']))
{
    lierQuizQuestion($_POST['idQuiz'], $_POST['idQuestion'], $_POST['positionQuestion']);
}
else
{
    echo "Erreur dans les paramètres passés à la liaison d'une question à un quiz.";
}