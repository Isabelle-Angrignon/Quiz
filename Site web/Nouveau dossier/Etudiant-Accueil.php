<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Vue/CSS/Etudiant-Accueil.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="Vue/CSS/DynamiqueQuestionARepondre.css" type="text/css" media="screen" >

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
            $("#DDL_Cours").selectmenu({
                select: function(event, ui) {
                    var idCours = $("#DDL_Cours option:selected").attr("value");
                     //updateUlQuiz( idCours );
                    $.ajax({
                        type:"POST",
                        url: 'Controleur/FonctionQuizEtudiant/SetIdCoursSession.php',
                        data:{'selectCours':idCours},
                        dataType:"text",
                        error: function() {
                            alert("Erreur");
                        }
                    });
                }
            });

            $("#UlQuizFormatif").click( function() {
                //appeler la fonction php qui génere une liste de questions;
                $("#quiz").submit();
            });

            $("#UlQuizAleatoire").click( function() {
                $("#quiz").submit();
            });

        });
    </script>

</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuEtudiant.php");

if (isset($_POST['DDL_Cours']))
{
    $_SESSION['idCours'] = $_POST['DDL_Cours'];
}
else
{
   $_SESSION['idCours'] = '0';
}
//////////click next/////////////////////
//Retirer une question de la liste:
if (isset($_SESSION['listeQuestions']) && !empty($_SESSION['listeQuestions']) )
{
    $idQuestion = $_SESSION['listeQuestions'][0];
    //recupérer infos question
    $_SESSION['infoQuestion'] = recupererElementsQuestion($idQuestion['idQuestion']);
    //$_SESSION['listeReponses'] = recuperer.
    ///////////////////////////////////////////.


}
///////////////////// fin click next ///////////////////////////



?>

<div class="contenu">
    <form id="quiz" action=GenererQuestionsAleatoires.php method="post">
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
        unset($_SESSION['listeQuestions'] );
    }
}

?>




</body>

</html>