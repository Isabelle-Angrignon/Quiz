<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/Etudiant-Accueil.css" type="text/css" media="screen" >

    <?php
    include("Vue/PHP de base/InclusionTemplate.php");
    include("Vue/PHP de base/InclusionJQuery.php");
    include("Vue/PHP de base/Utilitaires.php");
    include("Modele/FonctionsQuizEtudiant.php");
    ?>

    <script>
        // fait quoi
        $(function() {
            $("#DDL_Cours").selectmenu();
            $("#DDL_Cours").load(function() {
                ajouterOption_ToSelect("DDL_Cours","Un premier cours");
                ajouterOption_ToSelect("DDL_Cours","Un second cours");
                ajouterOption_ToSelect("DDL_Cours","Un troisième cours");
            });

            $("#UlQuiz").selectable();
            $("#UlQuiz").load(function() {
                ajouterLi_ToUl("UlQuiz","Un premier titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un second titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un troisième titre de quiz",true);
            });
        });
    </script>

</head>

<body>

<?php
include("Vue/PHP de base/EnteteSite.php");
include("Vue/PHP de base/MenuEtudiant.php");
demarrerSession();
redirigerSiNonConnecte();
?>

<div class="contenu">
    <fieldset><select id="DDL_Cours"><option value="Tous les cours">Tous les cours</option></select></fieldset>
    <div id="LBL_ListesGererQuiz">
        <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>
        <label id="ModifierQuiz" for="ListeModifQuiz">Modifier votre quiz ici</label>
        <label id="GererQuestions" for="ListeModifQuiz">Mes questions</label>
    </div>
    <div id="ListeQuiz"class="Liste ListeGererQuiz">
        <ul id="UlQuiz">
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 1</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 2</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 3</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 4</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 5</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 6</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 7</li>
        </ul>

        <p><?php  genererQuestionsAleatoires(4);  ?></p>
    </div>

    <!--
    <div id="ListeGererQuestions" class="Liste ListeGererQuiz">
        <ul id="UlQuestion">
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
        </ul>
        <div id="AjouterQuestion" class="ListeDivElementStyle">Ajouter une question</div>
    </div>
    -->

</div>

<?php
include("Vue/PHP de base/BasDePage.php");
?>

</body>

</html>