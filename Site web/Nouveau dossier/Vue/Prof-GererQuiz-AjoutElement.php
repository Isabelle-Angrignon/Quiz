<?php
include("../Modele/ModeleAssociationQuestionCours.php");
include("../Modele/ModeleUtilisateurs.php");
// Prof-GererQuiz-AjoutElement
// Par Mathieu Dumoulin
// Date: 13/10/2014
// Description: Ce fichier ajoute les éléments HTML selon la variable $_POST['action'] ainsi que des variables de session selon la variable $_POST['session']
if(isset($_POST['action']))
{
    if($_POST['action'] == 'nouveauCheckBox')
    {
        nouveauInputReponses("radio");
    }
    else if($_POST['action'] == 'listeCoursSelonQuestion')
    {
        $resultat = listerCoursSelonQuestion($_POST['idQuestion']);
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
    }
}

function nouveauInputReponses($typeInput) {
    echo "<li class='ui-sortable-handle ui-sortable'><input type='".$typeInput."' name='reponses' value='0'><div class='reponsesQuestion' contenteditable='true'></div></li>";
}