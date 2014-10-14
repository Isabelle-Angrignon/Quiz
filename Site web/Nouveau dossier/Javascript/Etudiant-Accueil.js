// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php




////////  A adapter pour mettre a jour la liste des quiz formatifs selon le id du cours.
function updateUlQuiz(idCours) {
    if(idCours != "") {
        $("#UlQuizFormatif li").remove();

        $.ajax({
            type: 'POST',
            url: 'Controleur/ListerQuestions.php',
            data: {"Triage":"default", "idCours":idCours , "idProprietaire": "420jean"},
            dataType: "json",
            success: function(resultat) {
                traiterJSONQuestions(resultat);
                // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
                addClickEventToQuestions();
            },
            error: function() {
                alert("Erreur! ");
            }
        });
    }

}