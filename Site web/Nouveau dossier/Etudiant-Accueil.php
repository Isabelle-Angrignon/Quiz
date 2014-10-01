<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/Etudiant-Accueil.css" type="text/css" media="screen" >

    <?php
    include("Vue/PHP de base/InclusionJQuery.php");
    include("Vue/PHP de base/InclusionTemplate.php");

    include("Vue/PHP de base/Utilitaires.php");
    include("Modele/FonctionsQuizEtudiant.php");
    ?>

    <script>

        $(function() {
            $("#DDL_Cours").selectmenu();
            $("#DDL_Cours").ready(function() {
                ajouterOption_ToSelect("DDL_Cours", "1","Un premier cours");
                ajouterOption_ToSelect("DDL_Cours", "2","Un second cours");
                ajouterOption_ToSelect("DDL_Cours", "3","Un troisième cours");
            });

            $("#UlQuizFormatif").selectable();
            $("#UlQuizFormatif").ready(function() {
                ajouterLi_ToUl_V2("UlQuizFormatif","Un premier titre de quiz","01",true);
                ajouterLi_ToUl_V2("UlQuizFormatif","Un second titre de quiz","02",true);
                ajouterLi_ToUl_V2("UlQuizFormatif","Un troisième titre de quiz","03",true);
            });
            $("#UlQuizAleatoire").click( function() {
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
    <fieldset><select id="DDL_Cours"><option value="Tous mes cours">Tous mes cours</option></select></fieldset>

    <!-- Entete du Cadre principal contenant tous les types de quiz -->
    <div id="LBL_ListesGererQuiz">

        <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>

        <label id="GenereQuestions" for="boutonAleatoire">Générer un quiz aléatoire</label>
    </div>
    <!-- Cadre principal contenant tous les types de quiz -->
    <div id="ListeQuiz"class="Liste ListeGererQuiz">
        <label>Formatif</label>
        <ul id="UlQuizFormatif">
            <!-- les items de quiz appaîtront ici -->
        </ul>
        <!--
        <label>Formatif</label>
        <ul id="UlQuizFormatif">
             les items de quiz appaîtront ici
        </ul>-->


    </div>

    <div id="QuizAleatoire" class="Liste ListeGererQuiz">
        <form action=genererQuestionsAleatoires(4) >
            <label>Aléatoire</label>
            <ul id="UlQuizAleatoire">
                <li class="ui-state-default" >Générer</li>

            </ul>
        </form>
    </div>




</div>

<?php  include("Vue/PHP de base/BasDePage.php");  ?>

</body>

</html>