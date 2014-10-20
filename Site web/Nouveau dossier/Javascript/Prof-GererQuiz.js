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
    $.ajax({
        type: "post",
        url: 'Vue/Prof-GererQuiz-AjoutElement.php',
        async:false,
        data:  {"session":true, "idQuestion":idQuestion, "etat":etat},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
function ajouterNouvelleReponse() {
    $.post('Vue/Prof-GererQuiz-AjoutElement.php', {"action":"nouveauCheckBox"}, function(resultat) {
        $("#Ul_Reponses").append(resultat);
    }, 'html');
}

// cocherCheckBoxCoursSelonQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Description: Cette fonction communique avec Vue/Prof-GererQuiz-AjoutElement.php en lui passant l'action qu'il veut commettre.
//              Cette page lui renvoie la liste des cours qui comporte la question passée en paramètre sous forme JSON.
//              Par la suite, dans l'attribut success, je coche chacune des CheckBox qui correspondent aux cours renvoyés.
function cocherCheckBoxCoursSelonQuestion(idQuestion) {
    $.ajax({
        type:"POST",
        url:'Vue/Prof-GererQuiz-AjoutElement.php',
        data: {"action":"listeCoursSelonQuestion", "idQuestion": idQuestion },
        dataType: "json",
        success: function(resultat){
            for(var i = 0; i < resultat.length; ++i) {
                $("#listeAjoutCours input[type=checkbox]").each(function(){
                    if($(this).attr("value") == resultat[i].idCours) {
                        $(this).prop('checked', true);
                    }
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function cocherTypeQuestionSelonQuestion(typeQuestion) {
    $("#TypeQuestion input[type=radio]").each(function() {
       if($(this).attr("value") == typeQuestion) {
     //   $(this).attr('checked', true);
          $(this).prop('checked', true);
       }
    });
}

// cocherTypeQuizAssocieSelonQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrant : typeQuiz = Un JSON comportant représentant tous les types (attribut typeQuiz) de quiz associés à la question
function cocherTypeQuizAssocieSelonQuestion(typeQuiz) {
    $("#TypeQuizAssocie input[type=checkbox]").each(function() {
        for(var i = 0; i < typeQuiz.length; ++i) {
            if($(this).attr("value") == typeQuiz[i].typeQuiz) {
                $(this).prop('checked', true);
            }
        }
    });
}

//function ajouterQuestion() {
function modifierQuestion() {
    // Pour commencer, je prend l'énoncé des réponses ainsi que leur état (cochée ou non)
    // reponsesEnString représente un string ayant la structure JSON pour facilement le convertir après en JSON.
    // Ouverture du string de format JSON
    var reponsesEnString = '{"reponses":[';

    // Pour chacune de mes réponses, je vérifie si elles sont cochées ou non et je prend leur énoncé.
    // Par la suite, j'ajoute ma réponse sous forme d'une rangée dans mon string de format JSON
    $("#Ul_Reponses li").each( function() {
        var estCoche = false;
        if($(this).children("input[type=checkbox]").prop("checked") == true) {
            estCoche = true;
        }
        reponsesEnString += '{"enonce":"'+$(this).children("div").text()+'", "estBonneReponse":"' + estCoche + '"},';
    });
    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    // et je ferme par la suite mon string de format JSON.
    reponsesEnString = reponsesEnString.substr(0,reponsesEnString.length -1) + "]}";
    // Je transforme mon string de format JSON en objet JSON
    var jsonReponses = JSON.parse(reponsesEnString);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    var jsonQuestion = {
        "enonceQuestion" : document.getElementById("EnonceQuestion").textContent
    };

    $.ajax({
        type:"POST",
        url:'Controleur/AJAX_AjouterQuestion.php',
        async : false,
        data: {},
        //dataType: "text",
        success: function(resultat){
            alert(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

/*function modifierQuestion() {
    alert("Modifier!");
}*/