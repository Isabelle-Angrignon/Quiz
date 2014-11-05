﻿// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


function addClickEventToQuestions(usagerCourant) {
    $("#UlQuestion li").off("click");
    $("#UlQuestion li").click( function() {
        if(usagerCourant != $(this).children(".divProfDansLi").attr("placeholder")) {
            swal("Oups",
            "Vous ne disposez pas des droits pour modifier cette question. Aucune modification ne sera sauvegardée.",
            "warning");

        }

        var etat = "";
        if($(this).attr("id") == -1) {
            etat = "nouvelleQuestion";
        }
        else {
            etat = "modifierQuestion";
            ajouterVariableSessionProprietaireQuestion($(this).children(".divProfDansLi").attr("placeholder"));
        }
        ajouterVariableSessionQuestion($(this).attr("id"), etat);
        creeFrameDynamique("popupPrincipal", "Vue/dynamique-GererQuestion.php");

    });
}

function gererChangementTypeQuestion(elemCourant, e) {
    if($(elemCourant).attr("value") == "VRAI_FAUX" ) {
        if($("#Ul_Reponses").children("li").length > 0) {
            if(reponsesSontValides()) {
                // Un SweetAlert qui demande confirmation pour supprimer les anciennes réponses
                swal({   title: "Êtes-vous sur?",
                    text: "Cette action va supprimer les anciennes réponses. Êtes-vous sur de vouloir continuer?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Supprimer les anciennes réponses"
                }, function(aAccepter){
                    if(aAccepter) {
                        $("#Ul_Reponses").html("");
                        ajouterReponsesVraiFaux();
                        desactiverUnInputTypeQuestion(elemCourant);
                        return true;
                    }
                    else {
                        return false;
                    }
                });
            }
            else {
                $("#Ul_Reponses").html("");
                ajouterReponsesVraiFaux();
                desactiverUnInputTypeQuestion(elemCourant);
                return true;
            }

        }
        else {
            ajouterReponsesVraiFaux();
            desactiverUnInputTypeQuestion(elemCourant);
            return true;
        }
    }
    else if($(elemCourant).attr("value") == "CHOIX_MULTI_UNIQUE") {
        desactiverUnInputTypeQuestion(elemCourant);
        $("#Ul_Reponses").html("");
        ajouterNouvelleReponse();
        ajouterNouvelleReponse();
        // Enable les boutons d'ajout et de suppression de réponse
        $("#reponseConteneur input[type=button]").removeAttr("disabled");
        // Je permet à l'usager de modifier le texte des réponses. Ça cancelle entre autre le event.preventDefault()
        $("#Ul_Reponses li .reponsesQuestion").keydown(function() {
            return true;
        });
        return true;
    }
}

function desactiverUnInputTypeQuestion(inputTypeQuestionADesactiver) {
    // Je remet actif l'ancien radio button qui était disabled
    $("#TypeQuestion li input[disabled=disabled]").attr("disabled",false);
    // Je désactive le radio button qui vient d'être pressé
    $(inputTypeQuestionADesactiver).attr("disabled", true);
}
function traiterJSONQuestions(resultat) {
    var enonceDeLaQuestion;
    var nomProf;
    var idProprietaire;
    for(var i = 0; i < resultat.length; ++i) {
        enonceDeLaQuestion = resultat[i].enonceQuestion;
        if(enonceDeLaQuestion.length > 24) {
            enonceDeLaQuestion = enonceDeLaQuestion.substring(0, 24) + "...";
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
// ajouterVariableSessionQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrants: idQuestion = Identifiant représentant la question dans la session
//           etat = Action causant l'ouverture du div dynamique
// Extrant: Il n'y a pas d'extrant
// Description: Cette fonction envoi, à l'aide de AJAX, les variables passées en paramètre dans la session
function ajouterVariableSessionQuestion(idQuestion, etat) {
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

// ajouterVariableSessionProprietaireQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrants: idProprietaire = Identifiant représentant le proprietaire de la question dans la session
// Extrant: Il n'y a pas d'extrant
// Description: Cette fonction envoi, à l'aide de AJAX, les variables passées en paramètre dans la session
function ajouterVariableSessionProprietaireQuestion(idProprietaire) {

    $.ajax({
        type: "post",
        url: 'Vue/Prof-GererQuiz-AjoutElement.php',
        async:false,
        data:  {"session":true, "idProprietaire":idProprietaire},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function enleverModificationReponse() {
    // Disable les boutons d'ajout et de suppression de réponse
    $("#reponseConteneur input[type=button]").attr("disabled", "disabled");
    // J'empêche l'usager de modifier le texte des réponses.
    $("#Ul_Reponses li .reponsesQuestion").keydown(function(e) {
        e.preventDefault();
    });
}

// ajouterReponsesVraiFaux
// Par Mathieu Dumoulin
// Description : Cette fonction ajoute les réponses vrai/faux dans le #Ul_Reponses
function ajouterReponsesVraiFaux() {
    // Création du frame des réponses vrai/faux
    $.when(ajouterNouvelleReponse(), ajouterNouvelleReponse()).done( function() {

        $("#Ul_Reponses li").ready(function() {
            // Réponse vrai
            $("#Ul_Reponses li:first-child").children(".reponsesQuestion").text("Vrai");
            $("#Ul_Reponses li:first-child").children("input[type=radio]").attr("value",1);

            // Réponse faux
            $("#Ul_Reponses li:nth-child(2)").children(".reponsesQuestion").text("Faux");
            $("#Ul_Reponses li:nth-child(2)").children("input[type=radio]").attr("value",0);

            enleverModificationReponse();
        });
    });
}

// reponsesSontValides
// Par Mathieu Dumoulin
// Description : Cette fonction vérifie si les réponses sont valides. Pour ce faire, il faut qu'il n'y ai
//               aucun énoncé vide et qu'au moins une réponse soit vrai.
function reponsesSontValides() {
    var reponsesSontNonVides = true;
    var uneBonneReponse = false;
    $("#Ul_Reponses li").each(function() {
        // Si j'ai une réponse qui est vide, mes réponses ne sont pas valides.
        if($(this).children(".reponsesQuestion").text().trim() == "")  {
            reponsesSontNonVides = false;
        }
        // Si j'ai au moins une réponse qui est Vrai
        if($(this).children("input").prop("checked") == true) {
            uneBonneReponse = true;
        }
    });

    return reponsesSontNonVides && uneBonneReponse;
}


function ajouterNouvelleReponse() {
    var aCocher;
    // Si je n'ai aucune réponse de coché, je coche cette nouvelle réponse
    $("#Ul_Reponses").children("li").length == 0? aCocher=1 : aCocher=0;

    $.ajax({
        type: "post",
        url: "Vue/Prof-GererQuiz-AjoutElement.php",
        data: {"action":"nouveauInput", "aCocher":aCocher},
        dataType: "html",
        async:false,
        success: function(resultat) {
            $("#Ul_Reponses").append(resultat);
        }
    });
}

function supprimerReponseCourante() {
    if($("#Ul_Reponses").children("li").length == 1) {
        swal("Oups", "Vous ne pouvez pas avoir de question sans aucune réponse", "error");
    }
    else if($(".Reponsefocused").length == 0) {
        swal("Oups", "Veuillez sélectionner une réponse pour la supprimer.", "warning");
    }
    else {
        // .remove() gère automatiquement de supprimer la classe de l'élément (en supprimant l'élément)
        $(".Reponsefocused").parent().remove();
    }
    // Si l'élément a déjà été supprimé, le sélecteur ne va correspondre à aucun élément et cette commande ne va pas être éxécutée.
    $(".Reponsefocused").removeClass("Reponsefocused");

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
            $(this).prop('disabled', true);
        }
    });
}


function cocherTypeQuestionSelonQuestion(typeQuestion) {
    $("#TypeQuestion input[type=radio]").each(function() {
       if($(this).attr("value") == typeQuestion) {
          $(this).prop('checked', true);
          $(this).prop('disabled', true);
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
    if( reponsesSontValides()) {
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
    else {
        swal("Oups !", "Cette question n'est pas valide car elle contient une réponse qui est vide et/ou ne contient pas de bonne réponse.", "warning");
    }

}

function modifierQuestion( idCreateur,idQuestion, idProprietaire) {

    if(idCreateur != idProprietaire) {
        swal("Avertissement",
            "Vous ne pouvez pas modifier cette question car vous n'êtes  pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la modifier.",
            "error" );
    }
    else if(reponsesSontValides()) {
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
    else {
        swal("Oups !", "Cette question n'est pas valide car elle contient une réponse qui est vide et/ou ne contient pas de bonne réponse.", "warning");
    }
}