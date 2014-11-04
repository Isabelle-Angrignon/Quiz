<?php
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
            <input type="text" id="TB_Nom" /><br>
            <input type="text" id="TB_Code"  /> <br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Modifier le cours</div>



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
        }
    });

    $('#DDL_Cours').ready(function(){
        ajouterOption_ToSelect('DDL_Cours','0','Je suis le cours 0');
        ajouterOption_ToSelect('DDL_Cours','1','Je suis le cours 1');
        ajouterOption_ToSelect('DDL_Cours','2','Je suis le cours 2');
    }).selectmenu();



</script>