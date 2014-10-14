<?php
// Prof-GererQuiz-AjoutElement
// Par Mathieu Dumoulin
// Date: 13/10/2014
// Description: Ce fichier ajoute les éléments HTML selon la variable $_POST['action'] ainsi que des variables de session selon la variable $_POST['session']
if(isset($_POST['action']))
{
    if($_POST['action'] == 'nouveauCheckBox')
    {
        nouveauCheckBox();
    }
    else if($_POST['action'] == 'listeCoursSelonQuestion')
    {
        echo listerCoursSelonQuestion($_POST['idQuestion']);
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

function nouveauCheckBox() {
    echo "<li class='ui-sortable-handle ui-sortable'><input type='checkbox' name='reponses' value='0'><div class='reponsesQuestion' contenteditable='true'></div></li>";
}