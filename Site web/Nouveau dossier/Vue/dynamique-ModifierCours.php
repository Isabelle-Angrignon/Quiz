<?php
// dynamique-ModifierCours.php
// Interface de modification d'un cours de la page Admin.php
?>


    <p class="titre">Modifier un cours</p>
    <hr>
    <select id="DDL_Cours">

        </select>
    <div class="conteneur" >
        <div class="gauche">
            Nom cours : <br>
            Code cours : <br>

        </div>

        <div class="droite">
            <input type="text" id="TB_Nom" tabindex="1" /><br>
            <input type="text" id="TB_Code" tabindex="2"  /> <br>
        </div>
    </div>
    <div id="soumettre" tabindex="3" class="ListeDivElementStyle JquerryButton">Modifier le cours</div>



<script>
    $("#deploiement").ready(function(){
        $("#TB_Nom").focus();

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
            setTimeout(function() {$("#TB_Nom").focus();}, 0);
        }
    });
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
            ModifierCoursAjax($("#DDL_Cours option:selected").attr("value"),$("#TB_Nom").val(),$("#TB_Code").val());
        }
    });

    $('#DDL_Cours').ready(function(){
        ListerCoursSelectAjax();
        var id = $("#DDL_Cours option:selected").attr("value");
        var text = $("#DDL_Cours option:selected").text();
        var codeCours = $("#DDL_Cours option:selected").attr("placeholder");
        $('#TB_Nom').val(text);
        $('#TB_Code').val(codeCours);
    }).selectmenu({
        select: function(event, ui) {
            var id = $("#DDL_Cours option:selected").attr("value");
            var text = $("#DDL_Cours option:selected").text();
            var codeCours = $("#DDL_Cours option:selected").attr("placeholder");
            $('#TB_Nom').val(text);
            $('#TB_Code').val(codeCours);
        }
    });



</script>