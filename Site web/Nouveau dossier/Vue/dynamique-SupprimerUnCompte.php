<?php
?>



    <p class="titre">Supprimer un étudiant</p>
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

            ChercherUsagerAjax($('#TB_DA').val(),supprimerUnCompte, " dont vous souhaitez supprimer le compte");

        }
        else{
            swal({title:"Erreur" ,type:"warning", text:"Le numéro de DA n'est pas conforme"});
        }
    });

</script>