<?php
?>
<?php
?>

<script>
    $('#coursPost').val($('#QuizDropZone').children().attr('id'));
    //$('#coursPost').hide();
</script>

<div id="login">
    <p class="titre">Insérer votre fichier csv</p>
    <hr>
    <div class="conteneur" >
        <form id="Form_CSV" action="../Controleur/cFonctionsGestionFichier.php" method="post"
              enctype="multipart/form-data">
            <input type="hidden" id="coursPost" name="cours"></input>
            <label for="file">nom du fichier:</label>
            <input type="file" name="file" id="file"><br>
            <div id="soumettre" class="ListeDivElementStyle BoutonDiv">Ajouter le cours</div>
        </form>
    </div>


</div>

<script>
    $('#soumettre').click(function(){
        $('#Form_CSV').submit();
    });

</script>