<?php
?>



    <p class="titre">Nommer un nouvel Admin</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            DA du professeur : <br>
        </div>

        <div class="droite">
            <input type="text" id="TB_DA" /><br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Rendre administrateur</div>



<script>
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if($('#TB_DA').val().length != 0 && $('#TB_DA').val().length <= 10 && $('#TB_DA').val()[0] == "4") {

           ChercherUsagerAjax($('#TB_DA').val(),nommerAdminAjax);

        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numéro de DA n'est pas conforme"});
        }
    });

</script>