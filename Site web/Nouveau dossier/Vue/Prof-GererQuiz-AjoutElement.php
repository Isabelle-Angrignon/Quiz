<?php
// Prof-GererQuiz-AjoutElement
// Par Mathieu Dumoulin
// Date: 13/10/2014
// Description: Ce fichier ajoute les éléments HTML selon la variable $_POST['action']
if(isset($_POST['action']))
{
    if($_POST['action'] == 'nouveauCheckBox')
    {
        nouveauCheckBox();
    }
}

function nouveauCheckBox() {
    echo "<li class='ui-sortable-handle ui-sortable'><input type='checkbox' name='reponses' value='0'><div class='reponsesQuestion'></div></li>";
}