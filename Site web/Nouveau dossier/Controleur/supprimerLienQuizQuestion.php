<?php

include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleAssociationQuizQuestions.php");

if(isset($_POST['idQuiz']) && isset($_POST['idQuestion']))
{
    supprimerLienQuizQuestion($_POST['idQuiz'], $_POST['idQuestion']);
}
else
{
    echo "Erreur dans les paramètres passés à la suppression de la liaison d'une question à un quiz.";
}