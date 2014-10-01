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
                ajouterOption_ToSelect("DDL_Cours","Un premier cours", "1");
                ajouterOption_ToSelect("DDL_Cours","Un second cours", "2");
                ajouterOption_ToSelect("DDL_Cours","Un troisième cours", "3");
            });

            $("#UlQuiz").selectable();
            $("#UlQuiz").load(function() {
                ajouterLi_ToUl("UlQuiz","Un premier titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un second titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un troisième titre de quiz",true);
            });
            $("#QuizAleatoire").click( function() {
                //appeler la fonction php;
                this.submit = true;
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
    <!-- Liste déroulante pour choisir un cours -->
    <fieldset><select id="DDL_Cours"><option value="Tous les cours">Tous les cours</option></select></fieldset>

    <!-- Entete du Cadre principal contenant tous les types de quiz -->
    <div id="LBL_ListesGererQuiz">

        <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>

        <label id="GenereQuestions" for="boutonAleatoire">Générer un quiz aléatoire</label>
    </div>
    <!-- Cadre principal contenant tous les types de quiz -->
    <div id="ListeQuiz"class="Liste ListeGererQuiz">
        <label>Formatif</label>
        <ul id="UlQuizFormatif">
            <li class="ui-state-default">Quiz 1</li>
            <li class="ui-state-default">Quiz 2</li>
            <li class="ui-state-default">Quiz 3</li>
            <li class="ui-state-default">Quiz 4</li>
            <li class="ui-state-default">Quiz 5</li>
            <li class="ui-state-default">Quiz 6</li>
            <li class="ui-state-default">Quiz 7</li>
        </ul>


    </div>
    <form action=genererQuestionsAleatoires(4) >
    <div id="QuizAleatoire"class="Liste ListeGererQuiz">
        <label>Aléatoire</label>
        <ul id="UlQuizAleatoire">
            <li class="ui-state-default" >Générer</li>

        </ul>


    </div>
    </form>



</div>

<?php  include("Vue/PHP de base/BasDePage.php");  ?>

</body>

</html>