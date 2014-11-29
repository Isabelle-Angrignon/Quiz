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
    gestionParamChange();
    redirigerSiNonConnecte('Etudiant');

    $texteGenererAleatoire = "OUTIL DE PRATIQUE:
                                Génère aléatoirement une série de questions provenant de la banque de questions du cours choisi.
                                Vous pouvez quitter quand vous le souhaiter.
                                Aucune statistique n'est conservée.
                                Votre prof peut vous suggérer un lien si vous avez une mauvaise réponse.";

    ?>

    <script src="Javascript/Etudiant-Accueil.js"></script>
    <script>
        $(function() {
            //Générer la gestion de click sur les formatifs
            addClickEventToQuizFormatif();

            $("#DDL_Cours").selectmenu({
                width:400,
                select: function(event, ui) {
                    //Permet de mettre à jour la liste des quiz formatifs (et éventuellemnt sommatifs) selon le cours choisi
                    //Si aucun cours choisi, listera tous les quiz.
                    SetIdCoursSession();
                    $("#UlQuizFormatif").empty();
                    listerQuizFormatifs();
                    //Regénérer la gestion de click sur les formatifs
                    addClickEventToQuizFormatif();
                }
            });

            $("#UlQuizAleatoire").click( function() {
                ouvrirUnQuiz("ALEATOIRE",null);
            });
            $("#BTN_QuizAleatoire").tooltip({ show: { delay: 300, effect : "fade", duration: 800 }   });
        });
    </script>

</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuEtudiant.php");

//Pour le premier affichage
resetVarSessionScoreAffiche();


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
               <?php
               //Remplissage initial de la liste des quiz, aucun cours sélectionné.
               ListerQuizDansUl("UlQuizFormatif", $_SESSION['idUsager'], 0 ,"FORMATIF", "divDansLi");
                ?>
            </ul>

        </div>
        <!-- <div id="ListeExamen" class="Liste ListeGererQuiz">
            <label>Sommatif / examen</label>
            <ul id="UlQuizSommatif">
                 les items de quiz appaîtront ici
            </ul>
        </div>-->
        <div id="QuizAleatoire" class="Liste ListeGererQuiz" >

            <label>Aléatoire</label>
            <ul id="UlQuizAleatoire">
                <li id="BTN_QuizAleatoire" class="ui-state-default" title="<?= $texteGenererAleatoire?>">Générer</li>
            </ul>

        </div>
    </form>
</div>

<?php  include("Vue/Template/BasDePage.php");  ?>

</body>

</html>