<?php
// DynamiqueCSV.php
//Interface d'intégration d'un fichier CSV
// Provoque un refresh et retourne a la page GererCours.php
?>


<script>
    $('#coursPost').val($('#QuizDropZone').children().attr('id'));
    //$('#coursPost').hide();
</script>


    <p class="titre">Insérer un fichier csv</p>
    <hr>
    <div class="conteneur" >
        <form id="Form_CSV" action="../Controleur/cFonctionsGestionFichier.php" method="post"
              enctype="multipart/form-data">
            <input type="hidden" id="coursPost" name="cours">
            <input type="file" name="file" id="file" accept=".csv"><br>
            <div id="soumettre" class="ListeDivElementStyle JquerryButton">Ajouter le groupe</div>
        </form>



</div>

<script>
    $('#soumettre').button();

    $('#soumettre').click(function(){
        if ($('#file').val() != "" ){
             $('#Form_CSV').submit();
        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Veuillez choisir un fichier svp"});
        }

    });

</script>