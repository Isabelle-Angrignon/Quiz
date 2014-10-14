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
redirigerSiNonConnecte();

//recupérer infos question
$infoQuestion = $_SESSION['infoQuestion'];
//$listeReponses = $_SESSION['listeReponses'];

?>

<script>
    $(function() {
        $("#UlChoixReponse").selectable();
        $("#UlChoixReponse").click( function() {
            //appeler la fonction php pour changer la couleur;
        });

        //bouton suivant...
        $("#btnSuivant").click( function() {
            //gérer question actuelle
                //valider réponse
                alert('Coucou!!!!');
                //Update score page
                // Update stats bd
            //Load nouvelle question
                //viderHTMLfromElement
                //update infos question/réponse/liste...
                //insererHtmlFromPhp
        });


    });
</script>


<div id="divSuiviQuiz" class="suiviQuiz" >
    <label id="labelCours" class="suiviQuiz">Nom Cours ici <?php /* nom du cours  */   ?>   </label>

    <label id="labelScore" class="suiviQuiz"> 4 / 10 <?php  /*méthode qui récupère les infos de la session*/?> </label>

    <label id="labelTitre" class="suiviQuiz"> Aléatoire <?php  /*méthode qui récupère les infos de la session*/?> </label>
</div>
<div id="divSuiviQuiz2" class="suiviQuiz" >
    <label id="labelProp" class="suiviQuiz"> Quiz de:    <?php          ?>     </label>
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
        <button type="button" id="btnSuivant">
            Valider/Suivant
        </button>


    </div>


</div>


