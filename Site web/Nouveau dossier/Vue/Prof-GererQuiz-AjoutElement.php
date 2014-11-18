<?php
include("../Modele/ModeleAssociationQuestionCours.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleAssociationQuizCours.php");
// Prof-GererQuiz-AjoutElement
// Par Mathieu Dumoulin
// Date: 13/10/2014
// Description: Ce fichier ajoute les éléments HTML selon la variable $_POST['action'] ainsi que des variables de session selon la variable $_POST['session']
if(isset($_POST['action']))
{
    if($_POST['action'] == 'nouveauInput')
    {
        nouveauInputReponses("radio", $_POST['aCocher']);
    }
    else if($_POST['action'] == 'listeCoursSelonQuestion')
    {
        $resultat = listerCoursSelonQuestion($_POST['idQuestion']);
        echo  $resultat;
    }
    else if($_POST['action'] == 'listeCoursSelonQuiz')
    {
        $resultat = listerCoursSelonQuiz($_POST['idQuiz']);
        echo  $resultat;
    }
}
if(isset($_POST['session']))
{
    if($_POST['session'] == true)
    {
        session_start();
        // idQuestion
        isset($_POST['idQuestion'])? $_SESSION['idQuestion'] = $_POST['idQuestion'] : $_SESSION['idQuestion'] = NULL;
        // etat
        isset($_POST['etat'])? $_SESSION['etat'] = $_POST['etat'] : $_SESSION['etat'] = NULL;
        // idQuiz
        isset($_POST['idQuiz'])? $_SESSION['idQuiz'] = $_POST['idQuiz'] : $_SESSION['idQuiz'] = NULL;

        if(isset($_POST['idProprietaire']))
        {
            $_SESSION['idProprietaire'] = $_POST['idProprietaire'];
        }
    }
}

function nouveauInputReponses($typeInput, $aCocher) {
    $aCocher == 1? $checked="checked" : $checked="";
    echo "<li class='ui-sortable-handle ui-sortable'><input type='".$typeInput."' name='reponses' value='0' ".$checked."><textarea class='reponsesQuestion' rows='1' placeholder='Entrer une réponse ici...'></textarea></li>";
}