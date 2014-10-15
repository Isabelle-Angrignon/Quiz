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
    $('#soumettre').click(function(){
        $('#dFondOmbrage').remove();
        $('#DivDynamique').remove();
    });

</script>