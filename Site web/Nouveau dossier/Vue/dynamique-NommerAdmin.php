<?php
?>



    <p class="titre">Nommer un nouvel Admin</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            DA du professeur : <br>
        </div>

        <div class="droite">
            <input type="text" id="TB_DA" tabindex="1" /><br>
        </div>
    </div>
    <div id="soumettre" tabindex="2" class="ListeDivElementStyle JquerryButton">Rendre administrateur</div>



<script>
    $("#deploiement").ready(function(){
        $("#TB_DA").focus();

        $("#deploiement").keydown(function(e) {

            if(e.which == 13) {
                e.preventDefault();
                setTimeout(function() {$("#soumettre").click();}, 0);
            }
        });
    });
    $("#soumettre").keydown(function(e) {

        if(e.which == 9) {
            e.preventDefault();
            setTimeout(function() {$("#TB_DA").focus();}, 0);
        }
    });
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if($('#TB_DA').val().length != 0 && $('#TB_DA').val().length <= 10 && $('#TB_DA').val()[0] == "4") {

           ChercherUsagerAjax($('#TB_DA').val(),nommerAdminAjax," dont vous souhaitez rendre administrateur ?");
            $("#TB_DA").val("");
        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numéro de DA n'est pas conforme"});
        }
    });

</script>