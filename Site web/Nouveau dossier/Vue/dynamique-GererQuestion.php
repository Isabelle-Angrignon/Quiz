<?php
    include("../Controleur/Utilitaires.php");
    include("../Controleur/cFonctionsProf-GererQuiz.php");
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");
    include("../Modele/ModeleReponses.php");


    session_start();

    if(!isset($_GET["idQuestion"]))
    {
        trigger_error("Il n'y a aucun identifiant de question passé à ce div dynamique", E_USER_ERROR);
    }
    else if($_GET["idQuestion"] != null)
    {
        $maQuestion = getQuestion($_GET["idQuestion"]);
        $enonceQuestion = $maQuestion[0]["enonceQuestion"];
        $_SESSION['typeQuestion'] = $maQuestion[0]["typeQuestion"];
    }

?>
<script>
    $("#Ul_Reponses").sortable();/*.click(function(){
        if ( $(this).is('.ui-sortable-helper') || $(this).is('.ui-sortable-placeholder' ) {
            return;
        }
        $(this).sortable( "option", "disabled", true );
        var selector = this + " div";
        $(selector).attr('contenteditable','true');
    }).blur(function(){
            $(this).sortable( 'option', 'disabled', false);
            var selector = this + " div";
            $(selector).attr('contenteditable','false');
        });*/
</script>
<div id="QuestionConteneur">
    <div id="EnonceQuestion" contenteditable="true">
        <?php
            echo isset($enonceQuestion)?$enonceQuestion:"";
        ?>
    </div>
    <div id="reponseConteneur">
        <ul id="Ul_Reponses">
        <?php
            getReponsesFromQuestion($_GET["idQuestion"]);
        ?>
        </ul>
        <input type="button" id="BTN_AjouterReponse" onclick="ajouterNouvelleReponse()"  value="Ajouter une réponse">
    </div>
</div>


<?php

?>