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

    if(!isset($_SESSION['idUsager']))
    {
        // Gestion d'erreur s'il n'y a pas de connexion
        echo "<script> swal('Erreur de connexion','Erreur avec la connection. Veuillez vous reconnecter.', 'error');</script>";
        exit();
    }

    if(!isset($_SESSION["etat"]))
    {
        trigger_error("Il n'y a aucun état passé à ce div dynamique (modificationQuestion, nouvelleQuestion, ...)", E_USER_ERROR);
    }
    else if($_SESSION["etat"] == "modifierQuestion" && isset($_SESSION["idQuestion"]))
    {
        $maQuestion = getQuestion($_SESSION["idQuestion"]);
        $enonceQuestion = $maQuestion[0]["enonceQuestion"];
        $typeQuestion = $maQuestion[0]["typeQuestion"];
        $referenceWeb = $maQuestion[0]["referenceWeb"];
        $ordreReponsesAleatoire = $maQuestion[0]["ordreReponsesAleatoire"];
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
        $(this).sortable("option", "cancel", ".fixed");
    // Ici j'utilise l'event focusout car, contrairement à l'event blur, focusout est déclanché
    // lorsque l'élément en question perd son focus sur un de ses enfants
    }).focusout(function(){
        $(this).sortable( 'option', 'disabled', false);
        $(this).sortable("option", "cancel", "");
    });

    $("#EnonceQuestion").focusin(function() {
        $(this).css("background-color", "rgba(255, 255, 255, 0.62)");
    }).focusout(function() {
        $(this).css("background-color", "inherit");
    });

    addEventsToReponses();


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

    // Gère le autoheight du textarea représentant l'énoncé de la question
    function h(e) {
        $(e).css({'height':'auto'}).height(e.scrollHeight);
    }
    updateAutoSizeTextArea();
    // Ajoute la gestion des hotkeys sur le div dynamique.
    $(document).keydown(function(e) {
        if(e.ctrlKey == true) {
            // e.which == s
            if(e.which == 83) {
                if(!e.shiftKey) {
                    prevenirDefautDunEvent(e,function() { $("#BTN_ConfirmerQuestion").click(); });
                    <?php
                    if(isset($_SESSION['idProprietaire']) && $_SESSION['idProprietaire'] == $_SESSION['idUsager'])
                    {
                        echo '$(document).off("keydown");';
                    }
                    ?>
                }
                else {
                    $(document).off("keydown");
                    prevenirDefautDunEvent(e,function() { $("#BTN_ContinuerAjout").click();});
                }
            }
        }
    });

    // ----------------------------------------------------------------- //


    $("#BTN_ConfirmerQuestion").button();
    $("#BTN_SupprimerQuestion").button();
    $("#BTN_ContinuerAjout").button();

    $("#ordreReponsesQuestion").button().change(function() {
        if($(this).prop("checked") == true) {
            $(this).next("label").children("span").text("Fixe");
        }
        else {
            $(this).next("label").children("span").text("Aléatoire");
        }
    });

    $("#ordreReponsesQuestion+label").disableSelection();
    attribuerTabIndexToElemQuestion();
    $("#BTN_ConfirmerQuestion").keydown(function(e) {
        if(e.which == 9)
        {
            $("#EnonceQuestion").focus();
            prevenirDefautDunEvent(e, function() {});
        }
    });


</script>
<div id="QuestionConteneur">
    <div id="conteneurEnonceQuestion">
        <h2>Énoncé de la question</h2>
        <?php if(isset($_SESSION['idQuestion']) && $_SESSION["etat"] == "modifierQuestion") { echo "<div id='identifiantQuestion'> Id : " . $_SESSION['idQuestion'] . "</div>"; }?>
        <hr/>
        <textarea id="EnonceQuestion" rows='1' tabindex="1" placeholder="Entrer un énoncé ici..."><?php echo isset($enonceQuestion)?$enonceQuestion:""; ?></textarea>
    </div>
    <div id="reponseConteneur">

        <span id="titreReponses">
            <h2>Réponses</h2>
            <input type="checkbox" id="ordreReponsesQuestion"
            <?php if($_SESSION['etat'] == "modifierQuestion" && $ordreReponsesAleatoire == 1)
            {
                echo "><label for='ordreReponsesQuestion'>Aléatoire</label>";
            }
            else
            {
                echo "checked><label for='ordreReponsesQuestion'>Fixe</label>";
            }
            ?>
        </span>
        <hr/>
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
        <input type="button" id="BTN_AjouterReponse"  class="BTN_SousBouton" onclick="ajouterNouvelleReponse()"  value="Ajouter une réponse">
        <input type="button" id="BTN_SupprimerReponse" class="BTN_SousBouton" onclick="supprimerReponseCourante()" value="Supprimer une réponse">
    </div>
    <div id="conteneurLienWeb">
        <span id="lienWebQuestion"><h2>Lien web</h2><hr/></span>
        <input type="text" name="lienWeb" placeholder="Sera visible aux élèves s'ils ont une mauvaise réponse à cette question."
            <?php
                if($_SESSION["etat"] == "modifierQuestion")
                {
                    echo 'value="'. $referenceWeb .'"';
                }
            ?>
            >
    </div>
</div>
<div id="sectionDroiteQuestion">
    <div id="parametresQuestion">
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
                else
                {
                    echo "<script>cocherTypeQuizAssocieParDefaut('TypeQuizAssocie');</script>";
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
                        echo "<script>cocherCheckBoxCoursSelonCoursCourant('listeAjoutCours');</script>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <div id="hotKeys">
        <table>
            <tr><td>Ctrl+s</td><td>Enregistrer les modifications</td></tr>
            <tr><td>Ctrl+Shift + s</td><td>Ajouter la question et continuer</td></tr>
            <tr><td>Échap.</td><td>Ferme la fenêtre courrante</td></tr>
            <tr><td>Shift+Enter</td><td>Sur une réponse, ajoute une nouvelle réponse</td></tr>
            <tr><td>Shift+Suppr</td><td>Sur une réponse, supprime cette réponse</td></tr>
            <tr><td>Ctrl+ArrowUp</td><td>Dans la liste des réponses, navigue vers le haut</td></tr>
            <tr><td>Ctrl+ArrowDown</td><td>Dans la liste des réponses, navigue vers le haut</td></tr>
        </table>
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
            echo "Modifier onclick='modifierQuestion(\"".$UsagerCourrant."\",\"". $idQuestion."\", \"". $Proprietaire ."\")'>";
        }
        elseif( $_SESSION["etat"] == "nouvelleQuestion")
        {
            echo "Ajouter onclick='ajouterQuestion(\"".$_SESSION['idUsager']."\")'>";
            echo "<input type='button' id='BTN_ContinuerAjout' value='Ajouter et continuer' onclick='ajouterQuestion(\"".$_SESSION['idUsager']."\", \"continuer\")'>";
        }
    ?>
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
            echo '"Annuler l\'ajout" onclick="fermerDivDynamique()"';
        }
    ?>
    >
</div>
