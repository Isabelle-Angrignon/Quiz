<?php
// dynamique-InfoAdmin.php
// Interface donnant les infos pour la documentation et l'installation du serveur a un administrateur
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
    $("#deploiement").ready(function(){
        $("#soumettre").focus();
        $("#deploiement").keydown(function(e) {

            if(e.which == 13) {
                e.preventDefault();
                setTimeout(function() {$("#soumettre").click();}, 0);
            }
        });
    });
    $('#soumettre').button();
    $('#soumettre').click(function(){
        $('#deploiement').remove();
    });
</script>