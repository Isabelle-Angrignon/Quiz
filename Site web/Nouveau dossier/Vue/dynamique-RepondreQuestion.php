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

//recupérer infos question et quiz
$infoQuestion = $_SESSION['infoQuestion'];
$typeQuiz = $_SESSION['typeQuiz'];
$aleatoire = $typeQuiz == "ALEATOIRE";//booleen
isset($_SESSION['nomProf'])?$nomProf = $_SESSION['nomProf']:$nomProf="";
isset($_SESSION['titreQuiz'])?$titreQuiz = $_SESSION['titreQuiz']:$titreQuiz="";
if(isset($_SESSION['listeQuestions']) && isset( $_SESSION['listeQuestionRepondues'] )){
    $nbQuestionsARepondre = count($_SESSION['listeQuestions']) + count($_SESSION['listeQuestionRepondues']);
}
else{
    $nbQuestionsARepondre = "?";
}


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

        //bouton valider/suivant...
        $("#btnSuivant").button(); // attache le theme JQueryUI au bouton
        $("#btnSuivant").hide();
        $("#btnValider").button(); // attache le theme JQueryUI au bouton
        $("#btnValider").click( function() {
            var lien = "<?php echo $_SESSION["infoQuestion"][0]['referenceWeb']; ?>";
            lien = lien!=null?lien:"";
            var typeQuiz = "<?php echo $_SESSION["typeQuiz"]; ?>";
            gererQuestionRepondue(lien, typeQuiz );
        });
    });
</script>

<div id="enteteQuiz" class="suiviQuiz">
    <table class="suiviQuiz">
        <tr>
            <td>
                <label id="labelCours" class="suiviQuiz">
                    <?php    echo getNomCours();  ?>
                </label>
            </td>
            <td>
                <label id="labelScore" class="suiviQuiz">
                    <?php
                    if($aleatoire) {
                        echo($_SESSION['bonnesReponses'] . ' / ' . $_SESSION['questionsRepondues']);
                    }
                    else{
                        echo($_SESSION['bonnesReponses'] . ' / ' . $_SESSION['questionsRepondues']) . " de " . $nbQuestionsARepondre;
                    }
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label id="labelTitreQuiz" class="suiviQuiz">
                    <?php if(!$aleatoire){ echo $titreQuiz; } ?>
                </label>
            </td>
            <td>
                <label id="labelType" class="suiviQuiz">
                    <?php  echo $typeQuiz; ?>
                </label>
                <br/>
                <label id="labelProp" class="suiviQuiz">
                    <?php
                    if($aleatoire)
                    {
                        echo "Cours de: " . getNomProfDuCoursDeLEtudiant();
                    }
                    else
                    {
                        echo "Quiz de: " . $nomProf;
                    }
                    ?>
                </label>
            </td>
        </tr>
    </table>

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
                echo 'Question de : '. $infoQuestion[0]['prof'] . '</br> ';
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

    <div id="bouttonValider" class="zoneQuestion">
        <button type="button" id="btnValider">Valider</button>
    </div>
    <div id="bouttonSuivant" class="zoneQuestion">
        <button type="button" id="btnSuivant">Suivant</button>
    </div>
</div>


