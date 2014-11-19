<?php
?>



    <p class="titre">Réinitialisation d'un mot de passe</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Numéro de DA : <br>
        </div>

        <div class="droite">
            <input type="text" id="TB_DA" /><br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Réinitialiser</div>



<script>
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if($('#TB_DA').val().length != 0 && $('#TB_DA').val().length <= 10) {

            ChercherUsagerAjax($('#TB_DA').val(),reinitialiserMotDePasse, " sur qui vous voulez réinitialiser le mot de passe ?");

        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numéro de DA n'est pas conforme"});
        }
    });

</script>