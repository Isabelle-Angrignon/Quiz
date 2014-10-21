<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Vue/CSS/Etudiant-Accueil.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="Vue/CSS/DynamiqueQuestionARepondre.css" type="text/css" media="screen" >

    <!--   Pour Sweet Alert -->
    <script src="sweetalert-master/lib/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="sweetalert-master/lib/sweet-alert.css">

    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    include("Controleur/cFonctionsCours.php");
    include("Modele/ModeleCours.php");
    include("Modele/mFonctionsQuizEtudiant.php");
    include("Controleur/cFonctionsQuizEtudiant.php");
    include("Modele/ModeleQuestions.php");
    include("Modele/ModeleInscriptionsEtudiantCours.php");

    demarrerSession();
    redirigerSiNonConnecte();
    ?>

    <script src="Javascript/Etudiant-Accueil.js"></script>
    <script>
        $(function() {
            $("#DDL_Cours").selectmenu();

            $("#UlQuizFormatif").click( function() {
                //appeler la fonction php qui génere une liste de questions pour un idQuiz spécifique...;
                $("#quiz").submit();
            });

            $("#UlQuizAleatoire").click( function() {

                if (SetIdCoursSession()==1)
                {
                    if (genererQuestionsAleatoires()==1)
                    {
                        alert('Quiz aléatoire généré, bonne chance');
                        creeFrameDynamique("QuestionAleatoire", "Vue/dynamique-RepondreQuestion.php");
                    }
                    else
                    {
                        alert ("Il n'y a aucune question aléatoire de créée pour ce cours.");
                    }
                }
                else
                {
                    alert ("Vous devez sélectionner un cours spécifique pour générer un quiz aléatoire");
                }
            });
        });
    </script>

</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuEtudiant.php");

//Pour le premier affichage
if(!isset($_SESSION['questionsRepondues']))
{
    $_SESSION['questionsRepondues'] = 0;
}
if(!isset($_SESSION['bonnesReponses']))
{
    $_SESSION['bonnesReponses'] = 0;
}

?>

<div class="contenu">
    <form id="quiz" action=Controleur/FonctionQuizEtudiant/GenererQuestionsAleatoires.php method="post">
        <!-- Liste déroulante pour choisir un cours -->
        <fieldset><select id="DDL_Cours" name="DDL_Cours">
                <?php
                ListerCoursDansSelect("DDL_Cours", true);
                ?>
            </select></fieldset>

        <!-- Entete du Cadre principal contenant tous les types de quiz -->
        <div id="LBL_ListesGererQuiz">

            <label id="GererQuiz" for="ListeQuiz">Mes quiz</label>

            <label id="GenereQuestions" for="boutonAleatoire">Générer un quiz aléatoire</label>
        </div>
        <!-- Cadre principal contenant tous les types de quiz -->
        <div id="ListeQuiz"class="Liste ListeGererQuiz">
            <label>Formatif</label>
            <ul id="UlQuizFormatif">
                <!-- les items de quiz apparaîtront ici -->
                <?php
                ListerQuizDansUl("UlQuizFormatif", $_SESSION["idUsager"], "get id cours dans ddl selected", "FORMATIF")
                ?>
            </ul>
            <!--
            <label>Formatif</label>
            <ul id="UlQuizFormatif">
                 les items de quiz appaîtront ici
            </ul>-->
        </div>

        <div id="QuizAleatoire" class="Liste ListeGererQuiz">

            <label>Aléatoire</label>
            <ul id="UlQuizAleatoire">
                <li class="ui-state-default" >Générer</li>
            </ul>

        </div>
    </form>
</div>

<?php

include("Vue/Template/BasDePage.php");

/*
//gestion des question du quiz...
if (isset($_SESSION["listeQuestions"]))
{
    if (!empty($_SESSION["listeQuestions"])) {
        echo ' <script>creeFrameDynamique("QuestionAleatoire", "Vue/dynamique-RepondreQuestion.php")</script> ';
        //retirer la première question de la liste, elle est récupérée au début de la page
        array_shift($_SESSION['listeQuestions']);/////////////////////next
    }
    else
    {
        resetVarSessionQuiz();
    }
}
*/
?>




</body>

</html>