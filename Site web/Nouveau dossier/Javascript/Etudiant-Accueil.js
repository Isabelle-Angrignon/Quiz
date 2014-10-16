// Etudiant-Accueil.js
// Par Isabelle Angrignon
// Date : 14/10/2014
// Description : Contient tout le code Javascript spécifique à la page Etudiant-Accueil.php

function genererQuestionsAleatoires()
{
    $.ajax({
        type:"POST",
        url:"GenererQuestionsAleatoires.php",
        success: function() {
            alert('Quiz généré, bonne chance');

        },
        error: function() {
            alert('Ajax ne marche pas');
        }
    });
}


function gererQuestionRepondue() {

//Récupérer le id de la réponse cliquée
    var idReponse;
    $("#UlChoixReponse .ui-selected").each(function() {
        idReponse = $(this).attr("id");
    });

//Valider cette réponse
     $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/validerReponseAQuestion.php",
        data: {"idReponse": idReponse},
        datatype: "text",
        success: function(resultat) {

            if (resultat == 1 || resultat == 0)
            {
                updateScoreAffiche(resultat);
                // Update stats bd
                // to do///////
            }
            //serie de if pour débuggage a remplacer par des sweetAlert.
            if(resultat == 1)
            {
                alert( ' Bonne réponse' );
            }
            else if(resultat == 0)
            {
                alert( ' Mauvaise réponse ' );
                // ajouter un ajax pour récupérer le lien hypertext de la question si il y en a une.
            }
            else if(resultat == 'X')
            {
                alert( ' Erreur au niveau de la validation' );
            }
            else
            {
                alert( ' Vous devez choisir une répone. ' );
            }
        },
        error: function() {
            alert('Ajax pour gerer la question répondue ne marche pas');
        }
    });
}

function updateScoreAffiche(resultat){
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/updateScoreAffiche.php",
        data: {"resultat": resultat},
        datatype: "text",
        success: function(score) {
            $('#labelScore').text(score);
        },
        error: function() {
            alert('marche pas');
        }
    });
}

function chargerNouvelleQuestion(){

   // viderHTMLfromElement('QuestionAleatoire');
    viderHTMLfromElement('QuestionAleatoire');
  //  $('#QuestionAleatoire').html("");

    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/chargerNouvelleQuestion.php",
        success: function(msg) {
            if (msg != null && msg != "" )
            {
                alert (msg);
            }
            alert ('succes ajax charger nouvelle question');
        },
        error: function() {
            alert('Ajax pour charger nouvelle question ne marche pas');
        }
    });
    //recharger le div dynamique
    insererHTMLfromPHP("QuestionAleatoire", "Vue/dynamique-RepondreQuestion.php")
}




////////////////////////////////////////////////////
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




