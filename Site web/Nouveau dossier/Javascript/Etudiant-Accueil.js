// Etudiant-Accueil.js
// Par Isabelle Angrignon
// Date : 14/10/2014
// Description : Contient tout le code Javascript spécifique à la page Etudiant-Accueil.php



function gererQuestionRepondue() {

//Récupérer le id de la réponse cliquée
    var idReponse;

        $("#UlChoixReponse .ui-selected").each(function() {
            idReponse = $(this).attr("id");
        });
    var resultat;

//Valider cette réponse
     $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/validerReponseAQuestion.php",
        data: {"idReponse": idReponse},
        datatype: "text",
        success: function(resultat) {//resultat recu sera "1" ou "0"
            "Ce que je veux faire avec le resultat"
            alert(resultat + ' ca marche' + idReponse);
            //Update score page
            // Update stats bd
            //Load nouvelle question
            //viderHTMLfromElement
            //update infos question/réponse/liste...
            //insererHtmlFromPhp
        },
        error: function(resultat) {
            alert('marche pas');
        }
    });
}






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




