<?php
?>

<p class="titre">Connection à la documentation</p>
<hr>
<div class="conteneur" >
    <div class="gauche">
        Email : <br>
        Mot de passe : <br>
    </div>

    <div class="droite">
        lequizinfo@gmail.com<br>
        Quiz2014<br>
    </div>
</div>
<div id="soumettre" class="ListeDivElementStyle JquerryButton">Fermer</div>

<script>
    $('#soumettre').button();
    $('#soumettre').click(function(){
        $('#deploiement').remove();
    });
</script>