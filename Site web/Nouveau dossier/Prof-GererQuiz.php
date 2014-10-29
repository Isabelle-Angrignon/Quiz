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

    demarrerSession();
    gestionParamChange();
    redirigerSiNonConnecte('Prof');

    ?>

    <script src="Javascript/Generique.js"></script>
    <script src="Javascript/GererCours.js"></script>
    <script src="Javascript/Prof-GererQuiz.js"></script>

    <script>

        $(function() {
               /* $("#UlQuiz").sortable({
                    connectWith: "#QuizDropZone",
                    revert: 150
                }).disableSelection();*/
                $("#UlModifQuiz").sortable({
                    connectWith: "#UlQuestion",
                    revert: 150,
                    helper : 'clone'
                }).disableSelection();
                $("#UlQuestion").sortable({
                    revert: 150,
                    helper : 'clone'
                }).disableSelection();
                $("#QuizDropZone").sortable({
                    connectWith: "#UlQuiz",
                    revert: 150
                }).disableSelection();


               $("#DDL_Cours").selectmenu({
                    width:400,
                    select: function(event, ui) {
                         var id = $("#DDL_Cours option:selected").attr("value");
                         updateUlQuestion( id, <?php echo '"'.$_SESSION["idUsager"].'"' ?> );
                    }
                });

                addClickEventToQuestions(<?php echo '"'.$_SESSION["idUsager"].'"';  ?>);

                $("#AjouterQuestion").click( function() {
                    ajouterVariableSessionQuestion("", "nouvelleQuestion");
                    creeFrameDynamique("popupPrincipal", "Vue/dynamique-GererQuestion.php");
                });
        });

    </script>

</head>

<body>

<?php
    include("Vue/Template/EnteteSite.php");
    include("Vue/Template/MenuProf.php");

?>

<div class="contenu">
    <fieldset><select id="DDL_Cours">
            <?php
            ListerCoursDansSelect("DDL_Cours", false);
            ?>
        </select></fieldset>
    <div id="LBL_ListesGererQuiz">
        <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>
        <label id="ModifierQuiz" for="ListeModifQuiz">Modifier un quiz ici</label>
        <label id="GererQuestions" for="ListeModifQuiz">Questions disponibles</label>
    </div>
    <div id="ListeQuiz"class="Liste ListeGererQuiz">
        <ul id="UlQuiz">
            <li class="ui-state-default">Quiz mi-session</li>
            <li class="ui-state-default">Quiz méchant</li>
            <li class="ui-state-default">Quiz sur les singes</li>
        </ul>
        <div id="ajouterQuiz"></div>
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