<?php
?>

<div id="login">
    <p class="titre">Nouveau Cours</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Nom Cours : <br>
            Code Cours : <br>

        </div>

        <div class="droite">
            <input type="text" id="TB_Nom" /><br>
            <input type="text" id="TB_Code"  /> <br>
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle BoutonDiv">Ajouter le cours</div>

</div>

<script>
    function estValide(){
        temp = true;
        temp = ($('#TB_Nom').val() != "" && $('#TB_Code').val() != "" );
        if (temp == false){alert('Certain champs sont vide');}
        temp = ($('#TB_Nom').val().length <= 200 && $('#TB_Code').val().length <= 10 );
        if (temp == false){alert('Certain champs sont trop long');}
        return temp;
    }
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