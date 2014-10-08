<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Vue/CSS/Etudiant-Accueil.css" type="text/css" media="screen" >

    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");

    include("Controleur/cFonctionsCours.php");
    include("Modele/ModeleCours.php");
    include("Modele/mFonctionsQuizEtudiant.php");
    include("Controleur/cFonctionsQuizEtudiant.php");
    ?>

    <script>
        $(function() {
            $("#DDL_Cours").selectmenu();

            $("#UlQuizFormatif").selectable();

            $("#UlQuizAleatoire").click( function() {
                //appeler la fonction php;
                this.submit = true;
                creeFrameDynamique();
            });
        });
    </script>

</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuEtudiant.php");
demarrerSession();
redirigerSiNonConnecte();
?>

<div class="contenu">
    <!-- Liste déroulante pour choisir un cours -->
    <fieldset><select id="DDL_Cours" name="DDL_Cours">
            <?php
            ListerCoursDansSelect("DDL_Cours", false);
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
            $idCours = ListerQuizDansUl("UlQuizFormatif", $_SESSION["idUsager"], "get id cours dans ddl selected", "FORMATIF")
            ?>
        </ul>


        <!--
        <label>Formatif</label>
        <ul id="UlQuizFormatif">
             les items de quiz appaîtront ici
        </ul>-->


    </div>

    <div id="QuizAleatoire" class="Liste ListeGererQuiz">
        <form action=genererQuestionsAleatoires() >
            <label>Aléatoire</label>
            <ul id="UlQuizAleatoire">
                <li class="ui-state-default" >Générer</li>

            </ul>
            <?php if (isset($_SESSION['listeQuestionsAleatoires']))
            {
                echo 'print_r($_SESSION[\'listeQuestionsAleatoires\'])';
            }
            ?>
        </form>
    </div>




</div>

<?php  include("Vue/Template/BasDePage.php");  ?>

</body>

</html>