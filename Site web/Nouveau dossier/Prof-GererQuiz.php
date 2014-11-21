<!-- Prof-GererQuiz
Par: Mathieu Dumoulin
Date: 19/09/2014
Description: Cette interface représente l'interface principale d'un professeur lorsqu'il veut modifier un quiz-->

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Vue/CSS/Prof-GererQuiz.css" type="text/css" media="screen" >

    <?php
        include("Vue/Template/InclusionJQuery.php");
        include("Vue/Template/InclusionTemplate.php");
        include("Controleur/cFonctionsProf-GererQuiz.php");
        include("Controleur/cFonctionsCours.php");
        include("Modele/ModeleCours.php");
        include("Modele/ModeleQuestions.php");
        include("Modele/ModeleQuiz.php");

    demarrerSession();
    gestionParamChange();
    redirigerSiNonConnecte('Prof');

    ?>

    <script src="Javascript/Generique.js"></script>
    <script src="Javascript/GererCours.js"></script>
    <script src="Javascript/Prof-GererQuiz.js"></script>

    <script>
        $(function() {
            $("#UlQuiz").sortable({
                connectWith: "#QuizDropZone",
                revert: 150,
                helper : 'clone'
            }).disableSelection();
            $("#UlModifQuiz").sortable({
                connectWith: "#UlQuestion",
                revert: 150,
                helper : 'clone',
                receive: function (event, ui) {
                    var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                    var idQuestion = $(ui.item).attr("id");
                    var positionDansQuiz = $(ui.item).index() + 1;
                    changerOrdreQuestionsDansQuiz();
                    lierQuestionAQuiz(idQuiz, idQuestion, positionDansQuiz);
                },
                remove: function (event, ui) {
                    var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                    var idQuestion = $(ui.item).attr("id");
                    changerOrdreQuestionsDansQuiz();
                    supprimerLienQuestionAQuiz(idQuiz, idQuestion);
                },
                update: function() {
                    changerOrdreQuestionsDansQuiz();
                }
            }).disableSelection();
            $("#UlQuestion").sortable({
                revert: 150,
                connectWith: "#UlModifQuiz",
                helper : 'clone',
                dropOnEmpty : false
            }).disableSelection();


            // Fonction qui gère quand qu'un li est drop dans le socle de modification de quiz.
            $("#QuizDropZone").sortable({
                connectWith: "#UlQuiz",
                revert: 150,
                helper : 'clone',
                receive: function (event, ui) {
                    $(ui.item).off("click");
                    //$("#UlQuiz").sortable("option", "connectWith", false);
                    if($("#QuizDropZone").children().length == 2)
                    {
                        $("#QuizDropZone").children().each(function() {
                            if($(this).text() != $(ui.item).text()){
                                $(this).appendTo("#UlQuiz");
                            }
                        });
                    }
                    $("#UlQuestion").sortable("option", "dropOnEmpty", true);
                    $('#UlModifQuiz').empty();
                    $('#UlQuestion').empty();
                    var idQuiz = $(ui.item).attr("id");
                    var idCours = $("#DDL_Cours option:selected").attr("value");
                    var typeQuiz = $(ui.item).children("div .divProfDansLi").text();
                    $("#TB_Filtre").val("");
                    updateUlModifQuiz("selonQuiz", <?php echo '"'.$_SESSION["idUsager"].'"' ?>, idQuiz);
                    updateUlQuestion( idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>, "pasDansCeQuiz", idQuiz, typeQuiz);
                },
                remove: function (event, ui) {
                    addClickEventToQuiz();
                    $("#UlQuestion").sortable("option", "dropOnEmpty", false);
                    $('#UlModifQuiz').empty();
                    $('#UlQuestion').empty();
                    var idCours = $("#DDL_Cours option:selected").attr("value");
                    $("#TB_Filtre").val("");
                    updateUlQuestion( idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>, "default");
                }
            }).disableSelection();

            // Ajout de l'évènement keydown sur les filtres (entre autre utilisé pour le enter qui simule le click sur le BTN_Filtre
            $("#TB_Filtre, #TB_FiltreID").keydown(function(e) {
                if(e.which == 13) {
                    $("#BTN_Filtre").click();
                }
            });

            $("#BTN_Filtre").click(function () {
                var idCours = $("#DDL_Cours option:selected").attr("value");
                var typeQuiz = $("#QuizDropZone").children("li").children("div .divProfDansLi").text();
                var idQuiz = $("#QuizDropZone").children("li").attr("id");
                var filtreEnonce = $("#TB_Filtre").val();///////////todo modif en cours....
                var filtreId = $("#TB_FiltreID").val();
                // Si il n'y a aucun quiz en modification
                if($("#QuizDropZone").children("li").length == 0) {
                    updateUlQuestion( idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>, "default", null, null, filtreEnonce, filtreId );
                }
                else {
                    updateUlQuestion( idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>, "pasDansCeQuiz", idQuiz, typeQuiz, filtreEnonce, filtreId);
                }
            });

            $("#DDL_Cours").selectmenu({
                width:400,
                select: function(event, ui) {
                    var idCours = $("#DDL_Cours option:selected").attr("value");
                    removeLiFromQuizDropZone();
                    updateUlQuestion( idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>,"default" );
                    updateUlQuiz(idCours, <?php echo '"'.$_SESSION["idUsager"].'"' ?>);
                }
            });
            function removeLiFromQuizDropZone() {
                $("#QuizDropZone li").remove();
                $("#UlQuiz").sortable("option", "connectWith", "#QuizDropZone");
                $("#UlQuestion").sortable("option", "dropOnEmpty", false);
                $('#UlModifQuiz').empty();
            }
            addClickEventToQuestions(<?php echo '"'.$_SESSION["idUsager"].'"';  ?>);
            addClickEventToQuiz();
            $("#AjouterQuestion").click( function() {
                ajouterVariableSessionQuestion("", "nouvelleQuestion");
                creeFrameDynamique("popupPrincipal", "Vue/dynamique-GererQuestion.php");
            });

            $("#ajouterQuiz").click( function() {
                ajouterVariableSessionQuiz("", "nouveauQuiz");
                creeFrameDynamique("divDynamiqueQuiz", "Vue/dynamique-GererQuiz.php");
            });
        });
    </script>

</head>

<body>

<?php
    include("Vue/Template/EnteteSite.php");
    include("Vue/Template/MenuProf.php");
//
?>

<div class="contenu">
    <div id="SectionFiltre">
        <fieldset>
            <select id="DDL_Cours">
                    <?php  ListerCoursDansSelect("DDL_Cours", false); ?>
             </select>
        </fieldset>
        <div id="filtres">
            id: <input type="text" id="TB_FiltreID"> Énoncé: <input type="text" id="TB_Filtre"> <input type="button" id="BTN_Filtre" value="Filtrer">
        </div>

    </div>

    <div id="LBL_ListesGererQuiz">
        <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>
        <label id="ModifierQuiz" for="ListeModifQuiz">Modifier un quiz ici</label>
        <label id="GererQuestions" for="ListeModifQuiz">Questions disponibles</label>
    </div>
    <div id="ListeQuiz"class="Liste ListeGererQuiz">
        <ul id="UlQuiz">
            <?php
                remplirListeQuiz($_SESSION['PremierCours'], $_SESSION["idUsager"]);
            ?>
        </ul>
        <div id="ajouterQuiz" class="ListeDivElementStyle">Ajouter un quiz</div>
    </div>
    <div id="ListeModifQuiz" class="Liste ListeGererQuiz">
        <div id="QuizDropZone" class="ListeDivElementStyle"></div>
        <ul id="UlModifQuiz"></ul>
    </div>
    <div id="ListeGererQuestions" class="Liste ListeGererQuiz">
        <ul id="UlQuestion">
            <?php
                remplirListeQuestions($_SESSION['PremierCours'], $_SESSION["idUsager"]);
            ?>
        </ul>
        <div id="AjouterQuestion" class="ListeDivElementStyle">Ajouter une question</div>
    </div>
</div>

<?php
    include("Vue/Template/BasDePage.php");
?>


</body>

</html>