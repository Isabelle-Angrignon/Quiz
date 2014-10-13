<?php  session_start();/*récupérer les infos de la question*/

//include("Template/InclusionJQuery.php");
include("..//Modele/ModeleUtilisateurs.php");
include("..//Modele/ModeleUsagers.php");
include("..//Controleur/Utilitaires.php");
include("..//Controleur/cFonctionsCours.php");
include("..//Modele/ModeleCours.php");
include("..//Modele/mFonctionsQuizEtudiant.php");
include("..//Controleur/cFonctionsQuizEtudiant.php");
include("..//Modele/ModeleQuestions.php");

//Retirer une question de la liste:
//$idQuestion = array_pop($_SESSION['listeQuestions']);
//recupérer infos question
$infoQuestion = $_SESSION['infoQuestion'];

//récupérer infos réponses

?>

<script>
    $(function() {

        $("#UlChoixReponse").selectable();
        $("#UlChoixReponse").click( function() {
            //appeler la fonction php pour changer la couleur;
            this.submit = true;
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
                foreach ($infoQuestion as $Questtion)
                {
                    echo 'Question de : '. $Questtion['idUsager_Proprietaire'] . '</br> ';
                }
            }
            ?>
        </label>

    </div>

    <div id="labelEnonce" class="zoneQuestion" >

        <label  class="zoneQuestion">
            <?php
            if (!empty($infoQuestion))
            {
                foreach ($infoQuestion as $Questtion)
                {
                    echo $Questtion['enonceQuestion'] ;
                }
            }
            ?>
        </label>
    </div>

    <ul id="UlChoixReponse" class="liste ">
        <!-- les choix de réponse apparaitront ici selon le type de question -->
        <?php
        genererChoixDeReponses(4,'VRAI_FAUX'); // no question et type question
        ?>
    </ul>


</div>


