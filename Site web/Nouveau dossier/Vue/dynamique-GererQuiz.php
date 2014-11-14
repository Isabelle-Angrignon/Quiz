<?php
    include("../Controleur/Utilitaires.php");
    session_start();
?>

<script>
    $(document).ready(function() {
        $("#DDL_Cours").children("option").each(function() {
            creerNouveauInput("checkbox","listeCoursQuiz", "cours", $(this).attr("value"), $(this).text(), 50);
            // Coche la checkbox des cours qui sont déjà lié à la question
        });
        $("#listeCoursQuiz input[type=checkbox]").click(function() {
            if($("#listeCoursQuiz input:checkbox:checked").length == 0) {
                $(this).prop('checked', true);
                swal("Erreur","Un quiz doit absolument être liée à un cours." ,"error");
            }
        });
        $("#paramQuiz").accordion({
            heightStyle:"content"
        }).disableSelection();

    });

</script>

<div id="sectionTitreQuiz">
    <input type="text" name="TitreQuiz" placeholder="Titre du quiz" id="titreQuiz">
</div>
<div id="paramQuiz">
    <h3>Ordre des questions</h3>
    <div>
        <ul id="ordreQuestionsQuiz">
            <input type="radio" name="ordreQuestions">Aléatoire <br/>
            <input type="radio" name="ordreQuestions">Fixe
        </ul>
    </div>
    <h3>Cours</h3>
    <div>
        <ul id="listeCoursQuiz">

        </ul>
    </div>

</div>
<div id="validationQuiz">
    <input type="button" value="Enregistrer" onclick="">
    <input type="button" value="Supprimer" onclick="">
</div>