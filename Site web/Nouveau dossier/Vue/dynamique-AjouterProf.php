<?php
// dynamique-AjouterProf.php
// Partie de page contenant un interface qui sert a créer une nouveau professeur.
// Fait aussi la vérification que l'usager rentre pas nimporte quoi
?>


<p class="titre">Nouveau professeur</p>
<hr>
<div class="conteneur" >
    <div class="gauche">
        Numero DA : <br>
        Nom : <br>
        Prénom
    </div>

    <div class="droite">
        <input type="text" id="TB_NumeroDA"  /><br>
        <input type="text" id="TB_Nom"  /> <br>
        <input type="text" id="TB_Prenom"  />
    </div>
</div>
<div id="soumettre" class="ListeDivElementStyle JquerryButton">Ajouter un professeur</div>



<script>
    function estValide(){
        temp = true;
        temp = ($('#TB_NumeroDA').val() != "" && $('#TB_Nom').val() != "" && $('#TB_Prenom').val() != "");
        if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont vides"});}
        if(temp ==true){
            temp = ($('#TB_NumeroDA').val().length <= 10 && $('#TB_Nom').val().length <= 50 && $('#TB_Prenom').val().length <= 30);
            if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont trop longs"});}
            if(temp ==true){temp = $('#TB_NumeroDA').val()[0] == "4"}
            if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Impossible de créer un professeur dont le numero de DA ne commence pas par 4"});}
        }
        return temp;
    }
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if(estValide()) {
            creerEtudiantCoursAjax($('#TB_NumeroDA').val(), $('#TB_Nom').val(), $('#TB_Prenom').val());

        }



    });

</script>