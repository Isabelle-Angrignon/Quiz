<?php
?>


    <p class="titre">Nouveau cours</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Nom cours : <br>
            Code cours : <br>

        </div>

        <div class="droite">
            <input type="text" id="TB_Nom" /><br>
            <input type="text" id="TB_Code"  /> <br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Ajouter le cours</div>



<script>
    function estValide(){
        temp = true;
        temp = ($('#TB_Nom').val() != "" && $('#TB_Code').val() != "" );
        if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont vides"});}
        else{
        temp = ($('#TB_Nom').val().length <= 200 && $('#TB_Code').val().length <= 10 );
        if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont trop longs"});}}
        return temp;
    }
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if (estValide()) {
            ajouterCoursAjax($('#TB_Nom').val(), $('#TB_Code').val())
            $('#UlCours').empty();
            ListerCoursAjax();
            $('#dFondOmbrage').remove();
            $('#DivDynamique').remove();
        }
    });

</script>