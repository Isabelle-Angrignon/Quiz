<?php
?>



    <p class="titre">Supprimer un compte</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Numéro de DA : <br>
        </div>

        <div class="droite">
            <input type="text" id="TB_DA" /><br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Supprimer</div>



<script>
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if($('#TB_DA').val().length != 0 && $('#TB_DA').val().length <= 10 && $('#TB_DA').val()[0] != "4") {

           // reinitialiserMotDePasse($('#TB_DA').val());

        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numéro de DA n'est pas conforme"});
        }
    });

</script>