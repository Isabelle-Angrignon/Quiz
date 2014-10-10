<?php  /*récupérer les infos de la question*/?>



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
    <label id="labelCours" class="suiviQuiz">Nom Cours ici <?php  /*le nom du chours tel que le selected*/?> </label>

    <label id="labelScore" class="suiviQuiz"> 4 / 10 <?php  /*méthode qui récupère les infos de la session*/?> </label>

    <label id="labelTitre" class="suiviQuiz"> Aléatoire <?php  /*méthode qui récupère les infos de la session*/?> </label>
</div>
<div id="divSuiviQuiz2" class="suiviQuiz" >
    <label id="labelProp" class="suiviQuiz">Nom du prof <?php  /*méthode qui récupère les infos de la question*/?> </label>
</div>


<div id="divQuestion" class="zoneQuestion" >

    <div id="labelEnonce" class="zoneQuestion" >
        <label  class="zoneQuestion">
            Super méga énoncé de question ici...
            <?php
            echo  $_SESSION['listeQuestions'][0][0] ;
            ?>


        </label>
    </div>

    <ul id="UlChoixReponse" class="liste ">
        <!-- les choix de réponse apparaitront ici selon le type de question -->
        <?php
       // genererChoixDeReponses(4,'VRAI_FAUX'); // no question et type question
        echo "<script>ajouterLi_ToUl_V2( 'UlChoixReponse' , 'Vrai', '1', true);</script>";
        echo "<script>ajouterLi_ToUl_V2( 'UlChoixReponse' , 'Faux', '0', true);</script>";
 //       GenererLi('UlChoixReponse', 'Vrai', 'V' );
  //      GenererLi('UlChoixReponse', 'Faux', 'F' );
        ?>
    </ul>


</div>


