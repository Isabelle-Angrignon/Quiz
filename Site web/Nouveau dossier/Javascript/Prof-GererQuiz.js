﻿// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


function addClickEventToQuestions(usagerCourant) {
    $("#UlQuestion li").off("click");
    $("#UlQuestion li").click( function() {
        if(usagerCourant == $(this).children(".divProfDansLi").attr("placeholder"))
        {
            var etat = "";
            if($(this).attr("id") == -1) {
                etat = "nouvelleQuestion";
            }
            else {
                etat = "modifierQuestion";
            }
            ajouterVariableSession($(this).attr("id"), etat);
            creeFrameDynamique("popupPrincipal", "Vue/dynamique-GererQuestion.php");
        }
        else
        {
            swal("Oups",
                "Vous ne disposez pas des droits pour modifier cette question. Veuillez contacter le propriétaire : " + $(this).children(".divProfDansLi").text(),
                "error");
        }

    });
}

function traiterJSONQuestions(resultat) {
    var enonceDeLaQuestion;
    var nomProf;
    var idProprietaire;
    for(var i = 0; i < resultat.length; ++i) {
        enonceDeLaQuestion = resultat[i].enonceQuestion;
        if(enonceDeLaQuestion.length > 25) {
            enonceDeLaQuestion = enonceDeLaQuestion.substring(0, 25) + "...";
        }
        nomProf = resultat[i].prenom + " " + resultat[i].nom;
        idProprietaire = resultat[i].idUsager_Proprietaire;
        ajouterLi_AvecDiv("UlQuestion", enonceDeLaQuestion, resultat[i].idQuestion, true, nomProf, "divProfDansLi", idProprietaire);
    }
}

function updateUlQuestion(idCours, usagerCourant) {
    if(idCours != "") {
        $("#UlQuestion li").remove();
        $.ajax({
            type: 'POST',
            url: 'Controleur/ListerQuestions.php',
            data: {"Triage":"default", "idCours":idCours , "idProprietaire":usagerCourant},
            dataType: "json",
            success: function(resultat) {
                traiterJSONQuestions(resultat);

                // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
                addClickEventToQuestions(usagerCourant);
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

function supprimerReponseCourante() {
    if($("#Ul_Reponses").children("li").length == 1) {
        swal("Oups", "Vous ne pouvez pas avoir de question sans aucune réponse", "error");
    }
    else if($(".Reponsefocused").length == 0) {
        swal("Oups", "Veuillez sélectionner une réponse pour la supprimer.", "warning");
    }
    else {
        $(".Reponsefocused").parent().remove();
    }

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

// cocherCheckBoxSelonValue
// Par Mathieu Dumoulin
// Date: 24/10/2014
// Intrants: idConteneur = le id du ul contenant ce CheckBox
// Description:
function cocherCheckBoxCoursSelonCoursCourant() {
    $("#listeAjoutCours li").children("input[type=checkbox]").each( function() {
       if($(this).attr("value") == $("#DDL_Cours option:selected").attr("value")) {
           $(this).prop('checked', true);
       }
    });
}

function cocherRadioButtonAvecValeur(valeur){
    $("#TypeQuestion li").children("input[type=radio]").each( function() {
        if($(this).attr("value") == valeur) {
            $(this).prop('checked', true);
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




// jsonifierReponsesQuestionCourante
// Par Mathieu Dumoulin
// Date: 20/10/2014
// Description: Cette fonction prend les réponses ouvertes en ce moment et construit un JSON les contenant.
//              Les réponses sont contenues dans leNomDeLaVariable.reponses[]
function jsonifierReponsesQuestionCourante() {
    // Pour commencer, je prend l'énoncé des réponses ainsi que leur état (cochée ou non)
    // reponsesEnString représente un string ayant la structure JSON pour facilement le convertir après en JSON.
    // Ouverture du string de format JSON
    var reponsesEnString = '{"reponses":[';

    // Pour chacune de mes réponses, je vérifie si elles sont cochées ou non et je prend leur énoncé.
    // Par la suite, j'ajoute ma réponse sous forme d'une rangée dans mon string de format JSON
    var position = 0;
    $("#Ul_Reponses li").each( function() {
        var estCoche = false;
        if($(this).children("input[type=radio]").prop("checked") == true) {
            estCoche = true;
        }
        // Rend les guillemets en caractère litéraire ce qui empêche les bugs dans le traitement de la chaine. (La chaine est entourée de base d'une paire de guillements)
        reponsesEnString += '{"enonce":"'+$(this).children("div").text().replace(/[\"]/g, '\\"')+'", "estBonneReponse":"' + estCoche + '",' +
                            '"idReponse":"' + $(this).children("input[type=radio]").attr("value") + '", "positionReponse":"'+ ++position +'"},';
    });

    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#Ul_Reponses li").length > 0) {
        reponsesEnString = reponsesEnString.substr(0,reponsesEnString.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    reponsesEnString += "]}";


    // Je transforme mon string de format JSON en objet JSON
    var jsonReponses = JSON.parse(reponsesEnString);

    return jsonReponses;
}

function jsonifierCoursQuestionCourante() {

    // Ouverture du string de format JSON
    var coursEnString = '{"cours":[';

    // Pour chacun de mes cours, je vérifie lesquels sont cochés et je prend leur énoncé.
    // Par la suite, j'ajoute mon cours sous forme d'une rangée dans mon string de format JSON
    $("#listeAjoutCours li").each( function() {
        if($(this).children("input[type=checkbox]").prop("checked") == true) {
            // Rend les guillemets en caractère litéraire ce qui empêche les bugs dans le traitement de la chaine. (La chaine est entourée de base d'une paire de guillements)
            coursEnString += '{"nomCours":"'+$(this).text().replace(/[\"]/g, '\\"')+'", "idCours":"'+ $(this).children("input[type=checkbox]").attr("value") + '"},';
        }
    });
    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#listeAjoutCours li input:checkbox:checked").length > 0) {
        coursEnString = coursEnString.substr(0,coursEnString.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    coursEnString += "]}";
    // Je transforme mon string de format JSON en objet JSON
    var jsonCours = JSON.parse(coursEnString);

    return jsonCours;
}


function jsonifierTypeQuizAssQuestionCourante() {

    // Ouverture du string de format JSON
    var typeQuizAssEnString = '{"typeQuizAss":[';

    // Pour chacun de mes typeQuizAss, je vérifie lesquels sont cochés et je prend leur nom.
    // Par la suite, j'ajoute mon typeQuizAss sous forme d'une rangée dans mon string de format JSON
    $("#TypeQuizAssocie li").each( function() {
        if($(this).children("input[type=checkbox]").prop("checked") == true) {
            typeQuizAssEnString += '{"nom":"'+$(this).text()+'", "id":"'+ $(this).children("input[type=checkbox]").attr("value") + '"},';
        }
    });

    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#TypeQuizAssocie li input:checkbox:checked").length > 0) {
        typeQuizAssEnString = typeQuizAssEnString.substr(0,typeQuizAssEnString.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    typeQuizAssEnString += "]}";
    // Je transforme mon string de format JSON en objet JSON
    var jsonTypeQuizAss = JSON.parse(typeQuizAssEnString);

    return jsonTypeQuizAss;
}

function getJSONEnonceQuestion(idCreateur, idQuestion ) {
    var enonce = document.getElementById("EnonceQuestion").textContent;

    // Par défaut, les furteurs tels que chrome et firefox ajoutent 13 caractères au début du texte d'un contentEditable élément.
    enonce = enonce.replace(/[\s]*/, "");
    // Rend les guillemets en caractère litéraire ce qui empêche les bugs dans le traitement de la chaine. (La chaine est entourée de base d'une paire de guillements)
    enonce = enonce.replace(/[\"]/g, '\\"');
    enonce = enonce.trim();
    var jsonQuestion = '{"enonceQuestion" : "' + enonce + '", "idUsager_Proprietaire":"' + idCreateur + '"';
    if(idQuestion != null) {
        jsonQuestion +=', "idQuestion":"'+ idQuestion+'"';
    }
    jsonQuestion += '}';
    jsonQuestion = JSON.parse(jsonQuestion);

    return jsonQuestion;
}

function ajouterQuestion(idCreateur) {

    var jsonQuestion = getJSONEnonceQuestion(idCreateur);

    var jsonReponses = jsonifierReponsesQuestionCourante();

    var jsonCours = jsonifierCoursQuestionCourante();

    var typeQuestion = $("#TypeQuestion li input[type=radio]:checked").attr("value");

    var jsonTypeQuizAss = jsonifierTypeQuizAssQuestionCourante();

    $.ajax({
        type:"POST",
        url:'Controleur/AJAX_AjouterQuestion.php',
        async : false,
        data: {"tableauQuestion":jsonQuestion, "tableauReponses":jsonReponses, "tableauCours":jsonCours,
                "typeQuestion":typeQuestion, "tableauTypeQuizAssocie":jsonTypeQuizAss},
        dataType: "text",
        success: function(resultat){
            if(resultat.trim() != "") {
                swal("Erreur !", resultat, "error");
            }
            else {
                $(".dFondOmbrage").detach();
                var cours = $("#DDL_Cours option:selected").attr("value");
                updateUlQuestion( cours, idCreateur );
                swal("Félicitation !", "Votre ajout de question à réussi", "success");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
        }
    });
}

function modifierQuestion( idCreateur,idQuestion) {
    var jsonQuestion = getJSONEnonceQuestion(idCreateur, idQuestion);

    var jsonReponses = jsonifierReponsesQuestionCourante();

    var jsonCours = jsonifierCoursQuestionCourante();

    var typeQuestion = $("#TypeQuestion li input[type=radio]:checked").attr("value");

    var jsonTypeQuizAss = jsonifierTypeQuizAssQuestionCourante();

    $.ajax({
        type:"POST",
        url:'Controleur/AJAX_ModifierQuestion.php',
        async : false,
        data: {"tableauQuestion":jsonQuestion, "tableauReponses":jsonReponses, "tableauCours":jsonCours,
            "typeQuestion":typeQuestion, "tableauTypeQuizAssocie":jsonTypeQuizAss},
        dataType: "text",
        success: function(resultat){
            if(resultat.trim() != "") {
                swal("Erreur !", resultat, "error");
            }
            else {
                $(".dFondOmbrage").detach();
                var cours = $("#DDL_Cours option:selected").attr("value");
                updateUlQuestion( cours, idCreateur );
                swal("Félicitation !", "Votre modification de question à réussi", "success");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
        }
    });
}