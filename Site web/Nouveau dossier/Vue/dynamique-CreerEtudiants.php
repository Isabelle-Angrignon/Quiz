<?php
?>
<?php
?>


    <p class="titre">Nouvel étudiant</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Numéro DA : <br>
            Nom : <br>
            Prénom :
        </div>

        <div class="droite">
            <input type="text" id="TB_NumeroDA"  /><br>
            <input type="text" id="TB_Nom"  /> <br>
            <input type="text" id="TB_Prenom"  />
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle JquerryButton">Ajouter l'étudiant</div>



<script>
    function estValide(){
        temp = true;
        temp = ($('#TB_NumeroDA').val() != "" && $('#TB_Nom').val() != "" && $('#TB_Prenom').val() != "");
        if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont vides"});}
        if(temp ==true){
        temp = ($('#TB_NumeroDA').val().length <= 10 && $('#TB_Nom').val().length <= 50 && $('#TB_Prenom').val().length <= 30);
        if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Certains champs sont trop longs"});}
            if(temp ==true){temp = $('#TB_NumeroDA').val()[0] != "4"}
            if (temp == false){swal({title:"Erreur" ,type:"warning", text:"Impossible de créer un étudiant dont le numéro de DA commence par 4"});}
        }
        return temp;
    }
    $('#soumettre').button();
    $('#soumettre').click(function(){
        if(estValide()) {
            creerEtudiantCoursAjax($('#TB_NumeroDA').val(), $('#TB_Nom').val(), $('#TB_Prenom').val())

            if ($('#QuizDropZone').children().length > 0) {
                $('#UlEtudiants').empty();
                remplirUIEtudiantCoursAjax($('#QuizDropZone').children().attr('id'));
            }
            else {
                $('#UlEtudiants').empty();
                ListerEtudiantAjax();
            }
            $('#dFondOmbrage').remove();
            $('#DivDynamique').remove();
        }

    });

</script>