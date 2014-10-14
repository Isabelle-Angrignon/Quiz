// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


function addClickEventToQuestions() {
    $("#UlQuestion li").off("click");
    $("#UlQuestion li").click( function() {
        var etat = "";
        if($(this).attr("id") == -1) {
            etat = "nouvelleQuestion";
        }
        else {
            etat = "modifierQuestion";
        }
        ajouterVariableSession($(this).attr("id"), etat);
        creeFrameDynamique("popupPrincipal", "Vue/dynamique-GererQuestion.php");
    });
}

function traiterJSONQuestions(resultat) {
    var enonceDeLaQuestion;
    for(var i = 0; i < resultat.length; ++i) {
        enonceDeLaQuestion = resultat[i].enonceQuestion;
        if(enonceDeLaQuestion.length > 25) {
            enonceDeLaQuestion = enonceDeLaQuestion.substring(0, 25) + "...";
        }
        ajouterLi_ToUl_V2("UlQuestion", enonceDeLaQuestion, resultat[i].idQuestion, true);
    }
}

function updateUlQuestion(idCours) {
    if(idCours != "") {
        $("#UlQuestion li").remove();

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
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
            }
        });
    }
}
// ajouterVariableSession
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrants: idQuestion = Identifiant représentant la question dans la session
//           etat = Action causant l'ouverture du div dynamique
// Extrant: Il n'y a pas d'extrant
// Description: Cette fonction envoi, à l'aide de AJAX, les variables passées en paramètre dans la session
function ajouterVariableSession(idQuestion, etat) {
    $.post('Vue/Prof-GererQuiz-AjoutElement.php', {"session":true, "idQuestion":idQuestion, "etat":etat});
}
function ajouterNouvelleReponse() {
    $.post('Vue/Prof-GererQuiz-AjoutElement.php', {"action":"nouveauCheckBox"}, function(resultat) {
        $("#Ul_Reponses").append(resultat);
    }, 'html');
}

function cocherCheckBoxCoursSelonQuestion(idQuestion) {
    $.ajax({
        type:"POST",
        url:'Prof-GererQuiz-AjoutElement.php',
        data: {"action":"listeCoursSelonQuestion", "idQuestion": idQuestion },
        datatype: "json",
        success: function(resultat){
            alert("allo");
            for(var i = 0; i < resultat.length; ++i) {
                alert(resultat[i].idCours);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
