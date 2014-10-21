<?php
    include("../Controleur/Utilitaires.php");
    include("../Controleur/cFonctionsProf-GererQuiz.php");
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");
    include("../Modele/ModeleReponses.php");
    include("../Modele/ModeleAssociationQuestionCours.php");
    include("../Modele/ModeleTypesQuestion.php");
    include("../Modele/ModeleTypesQuiz.php");
    include("../Modele/ModeleAssociationTypesQuizQuestion.php");

    session_start();

    if(!isset($_SESSION["etat"]))
    {
        trigger_error("Il n'y a aucun état passé à ce div dynamique (modificationQuestion, nouvelleQuestion, ...)", E_USER_ERROR);
    }
    else if($_SESSION["etat"] == "modifierQuestion" && isset($_SESSION["idQuestion"]))
    {
        $maQuestion = getQuestion($_SESSION["idQuestion"]);
        $enonceQuestion = $maQuestion[0]["enonceQuestion"];
        $typeQuestion = $maQuestion[0]["typeQuestion"];
    }

?>
<script>
    // En résumé, lorsque je clique sur un des div d'enoncé de réponse, s'il n'est pas déjà en train d'être déplacé,
    // disable son attribut qui le rend selectable jusqu'à temps qu'il perd le focus
    $("#Ul_Reponses").sortable().click(function(){
        if ( $(this).is('.ui-sortable-helper') ) {
            return;
        }
        $(this).sortable( "option", "disabled", true );
        $(this).children(".reponsesQuestion").attr('contenteditable','true');
        // Ici j'utilise l'event focusout car, contrairement à ce que blur fait, focusout est déclanché
        // lorsque l'élément en question perd son focus sur un de ses enfants
    }).focusout(function(){
        $(this).sortable( 'option', 'disabled', false);
        $(this).children(".reponsesQuestion").attr('contenteditable','false');
    });


    $("#parametresQuestion").accordion({
        heightStyle:"content"
    }).disableSelection();


    $("#DDL_Cours").children("option").each(function() {
        creerNouveauCheckBox("listeAjoutCours", "cours", $(this).attr("value"), $(this).text(), 40);
       // Coche la checkbox des cours qui sont déjà lié à la question
    });
    $("#listeAjoutCours input[type=checkbox]").click(function() {
       if($("#listeAjoutCours input:checkbox:checked").length == 0) {
           $(this).prop('checked', true);
           alert("Une question doit absolument être liée à un cours.");
       }
    });

 /*   $("#EnonceQuestion").ready(function () {

        alert($(this).html().length.toString());
       /*if($(this).text() == ) {
           alert($("#EnonceQuestion").text());
       }
    });*/

    $("#BTN_ConfirmerQuestion").button();

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
        if($_SESSION["etat"] == "modifierQuestion")
        {
            getReponsesFromQuestion($_SESSION["idQuestion"]);
        }
        ?>
        </ul>
        <input type="button" id="BTN_AjouterReponse" onclick="ajouterNouvelleReponse()"  value="Ajouter une réponse">
    </div>
</div>
<div id="parametresQuestion">
    <h3>Cours</h3>
    <div>
        <ul id="listeAjoutCours">
            <?php
                if($_SESSION["etat"] == "modifierQuestion")
                {
                    echo "<script>cocherCheckBoxCoursSelonQuestion(". $_SESSION['idQuestion'].");</script>";
                }
            ?>
        </ul>
    </div>
    <h3>Type de question</h3>
    <div>
        <ul id="TypeQuestion">
            <?php
                afficherTypesQuestions();
                if($_SESSION["etat"] == "modifierQuestion")
                {
                    echo "<script>cocherTypeQuestionSelonQuestion('".$typeQuestion."');</script>";
                }
            ?>
        </ul>
    </div>
    <h3>Type de quiz associé</h3>
    <div>
        <ul id="TypeQuizAssocie">
            <?php
                afficherTypesQuiz();
            if($_SESSION["etat"] == "modifierQuestion")
            {
                $typeQuiz = prendreTypeQuizAssocie($_SESSION['idQuestion']);
                echo "<script>cocherTypeQuizAssocieSelonQuestion(".json_encode($typeQuiz).");</script>";
            }
            ?>
        </ul>
    </div>
</div>
<div id="ActionQuestion">
    <input type="button" id="BTN_ConfirmerQuestion" value=
    <?php
        if($_SESSION["etat"] == "modifierQuestion")
        {
            echo "Modifier onclick='modifierQuestion()'";
        }
        elseif( $_SESSION["etat"] == "nouvelleQuestion")
        {
            echo "Ajouter onclick='ajouterQuestion()'";
        }
    ?>
        >
</div>
