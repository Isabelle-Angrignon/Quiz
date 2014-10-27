<?php
?>


    <p class="titre">Reinitialisation de mot de passe</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Numero de DA : <br>
        </div>

        <div class="droite">
            <input type="text" id="TB_DA" /><br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Reinitialiser le mot de passe</div>



<script>
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if($('#TB_DA').val().length != 0 && $('#TB_DA').val().length <= 10) {

            reinitialiserMotDePasse($('#TB_DA').val());

        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numero de DA n'est pas conforme"});
        }
    });

</script>