<?php
// dynamique-CreerCours.php
//  Partie de page contenant l'interface pour créer un nouveau cours et limite l'usager afin qu'il ne rentre pas nimporte quoi.

?>


    <p class="titre">Nouveau cours</p>
    <hr>
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
    <div id="soumettre" tabindex="3" class="ListeDivElementStyle JquerryButton">Ajouter le cours</div>



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
            swal({   title: "Êtes-vous sur?",
                text: "Voulez vous vraiment ajouter le cours : " + $("#TB_Nom").val() + " avec le code cours : " +
                $("#TB_Code").val() + " ? ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FFA64F",/*todo ancien... #DD6B55   */
                confirmButtonText: "Accepter "
            }, function(){
                ajouterCoursAjax($('#TB_Nom').val(), $('#TB_Code').val());
                $("#TB_Nom").val("");
                $("#TB_Code").val("");
            });

        }
    });

</script>