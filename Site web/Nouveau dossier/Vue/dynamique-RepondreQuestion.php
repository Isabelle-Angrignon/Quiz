<?php

//include("Template/InclusionJQuery.php");
include("..//Modele/ModeleUtilisateurs.php");
include("..//Modele/ModeleUsagers.php");
include("..//Controleur/Utilitaires.php");
include("..//Controleur/cFonctionsCours.php");
include("..//Modele/ModeleCours.php");
include("..//Modele/mFonctionsQuizEtudiant.php");
include("..//Controleur/cFonctionsQuizEtudiant.php");
include("..//Modele/ModeleQuestions.php");
include("..//Modele/ModeleReponses.php");

demarrerSession();
redirigerSiNonConnecte('Etudiant');

//recupérer infos question
$infoQuestion = $_SESSION['infoQuestion'];

?>

<script>
    $(function() {
        $("#UlChoixReponse").selectable({
            selected: function(event, ui) {
                $(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected").each(
                    function(key,value){
                        $(value).find('*').removeClass("ui-selected");
                    }
                );
            }
        });

        //bouton suivant...
        $("#btnSuivant").button(); // attache le theme JQueryUI au bouton
        $("#btnSuivant").click( function() {
            if(gererQuestionRepondue() == 1 )
            {
                if (quizTermine() == 1)

                {
                    afficherScoreFinal();
                    $('#dFondOmbrage').remove();
                }
                else {
                    chargerNouvelleQuestion();//dans la session
                }
            }
        });


    });
</script>


<div id="divSuiviQuiz" class="suiviQuiz" >
    <label id="labelCours" class="suiviQuiz"><?php echo getNomCours();   ?>   </label>
</div>
<div id="divSuiviQuizCentre" class="suiviQuiz" >
    <label id="labelScore" class="suiviQuiz">
        <?php  echo ($_SESSION['bonnesReponses'] . ' / ' . $_SESSION['questionsRepondues']);  ?>
    </label>

    <label id="labelTitre" class="suiviQuiz"> Aléatoire <?php   ?> </label>
</div>
<div id="divSuiviQuiz2" class="suiviQuiz" >
    <label id="labelProp" class="suiviQuiz"> Cours de:    <?php    echo getNomProfDuCoursDeLEtudiant()  ?>     </label>
</div>


<div id="divQuestion" class="zoneQuestion" >

    <div class="zoneReference">
        <label id="idQuestion" class="zoneReference" >
            <?php
            // idQuestion pour reference...
            echo "#id : " . $infoQuestion[0]['idQuestion']  . "</br>";
            ?>
        </label>
        <label  id="nomProfQuestion" class="zoneReference" >
            <?php
            if (!empty($infoQuestion))
            {
                echo 'Question de : '. $infoQuestion[0]['idUsager_Proprietaire'] . '</br> ';
            }
            ?>
        </label>
    </div>

    <div id="labelEnonce" class="zoneQuestion" >

        <label  class="zoneQuestion">
            <?php
            if (!empty($infoQuestion))
            {
                echo $infoQuestion[0]['enonceQuestion'];
            }
            ?>
        </label>
    </div>

    <div id="divChoixReponse"  class="Liste zoneQuestion ">
        <ul id="UlChoixReponse" >
            <!-- les choix de réponse apparaitront ici selon le type de question -->
            <?php
            genererChoixDeReponses( $infoQuestion[0]['idQuestion'] ,$infoQuestion[0]['typeQuestion'], $infoQuestion[0]['ordreReponsesAleatoire']); // no question et type question
            ?>
        </ul>
    </div>

    <div id="bouttonSuivant" class="zoneQuestion">
        <button type="button" id="btnSuivant">Valider & Suivant</button>
    </div>
</div>


