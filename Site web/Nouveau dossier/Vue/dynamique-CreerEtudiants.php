<?php
?>
<?php
?>

<div id="login">
    <p class="titre">Nouvel étudiant</p>
    <hr>
    <div class="conteneur" >
        <div class="gauche">
            Numero DA : <br>
            Nom : <br>
            Prenom
        </div>

        <div class="droite">
            <input type="text" id="TB_NumeroDA"  /><br>
            <input type="text" id="TB_Nom"  /> <br>
            <input type="text" id="TB_Prenom"  />
        </div>
    </div>
    <div id="soumettre" class="ListeDivElementStyle BoutonDiv">Ajouter le cours</div>

</div>

<script>
    function estValide(){
        temp = true;
        temp = ($('#TB_NumeroDA').val() != "" && $('#TB_Nom').val() != "" && $('#TB_Prenom').val() != "");
        if (temp == false){alert('Certain champs sont vide');}
        temp = ($('#TB_NumeroDA').val().length <= 10 && $('#TB_Nom').val().length <= 50 && $('#TB_Prenom').val() <= 30);
        if (temp == false){alert('Certain champs sont trop long');}
        return temp;
    }
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