<?php

include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleQuestions.php");


if(isset($_POST['idQuestion']))
{
    supprimerQuestion($_POST['idQuestion']);
}
else
{
    echo "Le id n'est pas set";
}
