<?php
    include("../Controleur/Utilitaires.php");
    include("../Controleur/cFonctionsProf-GererQuiz.php");
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");
    include("../Modele/ModeleReponses.php");
    include("../Modele/ModeleAssociationQuestionCours.php");
    include("../Modele/ModeleTypesQuestion.php");
    include("../Modele/ModeleTypesQuiz.php");
    include("../Modele/ModeleQuestionsVraiFaux.php");
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
        $(".reponsesQuestion:focus").addClass("Reponsefocused");
        // Ici j'utilise l'event focusout car, contrairement à ce que blur fait, focusout est déclanché
        // lorsque l'élément en question perd son focus sur un de ses enfants
    }).focusout(function(event){
        $(this).sortable( 'option', 'disabled', false);
        $(this).children(".reponsesQuestion").attr('contenteditable','false');
        if($(event.relatedTarget).attr("id") != "BTN_SupprimerReponse") {
            $(".Reponsefocused").removeClass("Reponsefocused");
        }
    });


    $("#parametresQuestion").accordion({
        heightStyle:"content"
    }).disableSelection();


    $("#DDL_Cours").children("option").each(function() {
        creerNouveauInput("checkbox","listeAjoutCours", "cours", $(this).attr("value"), $(this).text(), 40);
       // Coche la checkbox des cours qui sont déjà lié à la question
    });
    $("#listeAjoutCours input[type=checkbox]").click(function() {
       if($("#listeAjoutCours input:checkbox:checked").length == 0) {
           $(this).prop('checked', true);
           swal("Erreur","Une question doit absolument être liée à un cours." ,"error");
       }
    });

    var dictionnaireReponsesChoixMulti;
    $("#TypeQuestion li input[type=radio]").change(function(e) {
        // Si c'est vrai/faux
        if($(this).attr("value") == "VRAI_FAUX" ) {
            // Je sauvegarde mes anciennes réponses avant des supprimer
            dictionnaireReponsesChoixMulti = jsonifierReponsesQuestionCourante();
            $("#Ul_Reponses").html("");
            ajouterReponsesVraiFaux();
        }
        else if($(this).attr("value") == "CHOIX_MULTI_UNIQUE") {
            $("#Ul_Reponses").html("");
            if(dictionnaireReponsesChoixMulti == null) {
                // Par défaut, je met 2 réponses vides.
                ajouterNouvelleReponse();
                ajouterNouvelleReponse();
            }
            else {
                ajouterReponsesViaJSON(dictionnaireReponsesChoixMulti);
            }
            permettreModificationReponses();
        }
    });

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Je dois simuler un placeholder car, de base avec google Chrome et Firefox, les contentEditable div contiennent des charactères invisibles (pour le curseur)
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Met le placeholder si l'énoncé est vide
    $("#EnonceQuestion").ready(function() {
       if($("#EnonceQuestion").text().trim() == "") {
           $("#EnonceQuestion").addClass("enonceVide");
       }
    });
    // Met le placeholder si l'énoncé va être vide suite à cette action. Le retire sinon.
    $("#EnonceQuestion").keydown(function(event) {
        // Je ne vérifie pas si le texte est vide car avec les key events le résultat n'est pas fluide.
        // Keydown : Calcule si le texte est vide avant de capter la touche qui est entrée
        // Keyup : "Glitch" avant de retirer la classe (Elle est retirer seulement après que la lettre est ajoutée au texte et c'est visible).
        // event.which == 8  --> Un backspace
        if($(this).text().trim().length == 1 && event.which == 8) {
            $(this).addClass("enonceVide");
        }
        else if(event.which != 8) {
            $(this).removeClass("enonceVide");
        }
    });

    $("#BTN_ConfirmerQuestion").button();
    $("#BTN_SupprimerQuestion").button();

</script>
<div id="QuestionConteneur">
    <div id="EnonceQuestion" contenteditable="true" placeholder="Entrer un énoncé ici...">
        <?php
            echo isset($enonceQuestion)?$enonceQuestion:"";
        ?>
    </div>
    <div id="reponseConteneur">
        <ul id="Ul_Reponses">

        <?php
        if($_SESSION["etat"] == "modifierQuestion")
        {
            getReponsesFromQuestion($_SESSION["idQuestion"], $typeQuestion);
        }
        else if($_SESSION["etat"] == "nouvelleQuestion")
        {
            echo "<script>ajouterNouvelleReponse()</script>";
        }
        ?>
        </ul>
        <input type="button" id="BTN_AjouterReponse" onclick="ajouterNouvelleReponse()"  value="Ajouter une réponse">
        <input type="button" id="BTN_SupprimerReponse" onclick="supprimerReponseCourante()" value="Supprimer une réponse">
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
                else if($_SESSION["etat"] == "nouvelleQuestion")
                {
                    echo "<script>cocherCheckBoxCoursSelonCoursCourant();</script>";
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
                else if($_SESSION["etat"] == "nouvelleQuestion")
                {
                    echo "<script>cocherRadioButtonAvecValeur('CHOIX_MULTI_UNIQUE');</script>";
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
            $UsagerCourrant = $_SESSION['idUsager'];
            $idQuestion = $_SESSION['idQuestion'];
            isset($_SESSION['idProprietaire']) ? $Proprietaire = $_SESSION['idProprietaire'] : $Proprietaire = "";
            echo "Modifier onclick='modifierQuestion(\"".$UsagerCourrant."\",\"". $idQuestion."\", \"". $Proprietaire ."\")'";
        }
        elseif( $_SESSION["etat"] == "nouvelleQuestion")
        {
            echo "Ajouter onclick='ajouterQuestion(\"".$_SESSION['idUsager']."\")'";
        }
    ?>
    >
    <input type="button" id="BTN_SupprimerQuestion" value=
    <?php
        if($_SESSION["etat"] == "modifierQuestion")
        {
            $idQuestion = $_SESSION['idQuestion'];
            isset($_SESSION['idProprietaire']) ? $Proprietaire = $_SESSION['idProprietaire'] : $Proprietaire = "";
            echo "'Supprimer cette question' onclick='supprimerQuestion(\"".$UsagerCourrant."\",\"". $idQuestion."\", \"". $Proprietaire ."\")'";
        }
        elseif( $_SESSION["etat"] == "nouvelleQuestion")
        {
            echo '"Annuler l\'ajout" onclick="annulerQuestion()"';
        }
    ?>
    >
</div>
