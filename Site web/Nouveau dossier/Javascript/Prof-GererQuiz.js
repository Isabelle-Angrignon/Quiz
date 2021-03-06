﻿// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php

// addClickEventToQuestions
// Par Mathieu Dumoulin
// Description : Cette fonction retire et ajoute l'évènement clic sur les questions.
function addClickEventToQuestions(usagerCourant) {
    // Retire l'évènement pour ne pas avoir plusieurs fois le même évènement qui se déclanche par la suite sur les même actions.
    $("#UlQuestion li, #UlModifQuiz li").off("click");
    $("#UlQuestion li, #UlModifQuiz li").click( function() {
        // Si l'usager n'est pas l'usager proprietaire de la question, avertir l'usager
        if(usagerCourant != $(this).children(".divProfDansLi").attr("placeholder")) {
            swal("Oups",
            "Vous ne disposez pas des droits pour modifier cette question. Aucune modification ne sera sauvegardée.",
            "warning");
        }
        // Valeur par défaut de l'etat
        var etat = "";
        // Par défaut, j'initialise le id des nouvelles questions à -1
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

// addClickEventToQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction retire puis ajoute l'évènement clic sur les 'li' de la liste UlQuiz
function addClickEventToQuiz() {
    $("#UlQuiz li").off("click");
    $("#UlQuiz li").click( function() {
        ajouterVariableSessionQuiz($(this).attr("id"), "modifierQuiz");

        creeFrameDynamique("divDynamiqueQuiz", "Vue/dynamique-GererQuiz.php");
    });
}

// addEventsToReponses
// Par Mathieu Dumoulin
// Description : Cette fonction retire et ajoute les évènements qui sont liés aux réponses de la page dynamique-GererQuestion.php
function addEventsToReponses() {
    // Retire les évènements focusin et focusout
    $(".reponsesQuestion").off("focusin").off("focusout");
    // Gère l'ajout de la classe Reponsefocused lorsqu'une réponse à le focus
    $(".reponsesQuestion").focusin(function() {
        $(this).addClass("Reponsefocused");
        // Gère la suppression de la classe Reponsefocused lorsqu'une réponse perd le focus
    }).focusout(function(event) {
        // Je prend l'ancien élément qui à le focus ici car, à la suite du timeOut, this ne réprésente plus la question qui s'est faite focusOut
        var ancienFocus = this;
        // setTimeout est la pour contourner le fait qu'avec FireFox on ne peut pas accèder au nouvel élément qui a le focus
        setTimeout(function() {
            // Si le nouvel élément qui a le focus n'est pas le Boutton pour supprimer une réponse.
            // Cette vérification est faite car on veut, lors du clic sur ce boutton, capter tous les éléments qui ont la classe Reponsefocused et les supprimer.
            // En cliquant sur ce boutton, sans cette condition, la réponse que l'on veut supprimer perd la classe lorsque le focus n'est plus sur elle.
            // Alors cette condition est essentielle à la suppression d'une réponse.
            if($(document.activeElement).attr("id") != "BTN_SupprimerReponse") {
                $(ancienFocus).removeClass("Reponsefocused");
            }
        });
    });

    $(".reponsesQuestion").off("keydown");
    $(".reponsesQuestion").keydown(function(e) {
        if(e.shiftKey == true ) {
        // Si c'est shift+enter qui est appuyer
            if(e.which == 13) {
                prevenirDefautDunEvent(e, function() { $("#BTN_AjouterReponse").click() });
            }
            // Si c'est shift+Suppr
            else if(e.which == 46) {
                prevenirDefautDunEvent(e, function() { $("#BTN_SupprimerReponse").click() });
            }
        }
        else if(e.ctrlKey == true) {
            // Si c'est la flèche du haut
             if(e.which == 38) {
                 var currentIndex = $(".Reponsefocused").parent("li").index();
                 if(currentIndex != 0) {
                     e.preventDefault();
                     // nth-child à comme minimum 0. index() à comme minimum 1. Alors nth-child = index - 1
                     $("#Ul_Reponses").children("li:nth-child("+ (currentIndex)+")").children(".reponsesQuestion").focus();
                 }
             }
             // Si c'est la flèche du bas
            else if(e.which == 40) {
                 var currentIndex = $(".Reponsefocused").parent("li").index();
                 if(currentIndex != $("#Ul_Reponses li").length + 1) {
                     e.preventDefault();
                     // nth-child à comme minimum 0. index() à comme minimum 1. Alors nth-child = index - 1
                     $("#Ul_Reponses").children("li:nth-child("+ (currentIndex + 2)+")").children(".reponsesQuestion").focus();
                 }
             }
        }
    });

}

// prevenirDefautDunEvent
// Par Mathieu Dumoulin
// Intrants : event = l'événement dont on veut prévenir le comportement par défaut
//            fonction = une fonction qui va être éxécuté dans le timeOut
//            timeout = Le temps d'attente du timeOut. Par défaut, je l'initialise à 0.
// Description : Cette fonction sert seulement pour permettre d'empêcher le comportement par défaut des événements sous Firefox.
//               Sous chrome, un seul event.preventDefault() fonctionne parfaitement.
//               Sous Firefox, je dois forcer un timeout pour empêcher l'évènement de "bubble" tout de suite et d'accomplir son comportement par défaut.
// Solution alternatives qui ne fonctionnent pas sur Firefox : event.stopImmediatePropagation(), return false, event.stopPropagation()
function prevenirDefautDunEvent(event, fonction, timeout) {
    event.preventDefault();

    if(timeout == null) {
        setTimeout(function() {fonction();}, 0);
    }
    else {
        setTimeout(function() {fonction();}, timeout);
    }
}

// Gère le autoheight du textarea
function h(e) {
    // Ajuste le height de l'élément à la hauteur de son scroll pour simuler l'ajustement de la hauteur de l'élément.
    $(e).css({'height':'auto'}).height(e.scrollHeight);
}

function updateAutoSizeTextArea() {
    // Permet à tous les textArea de simuler l'ajustement de leur hauteur
    $('textarea').each(function () {
        h(this);
    }).on('input', function () {
        h(this);
    });
}

// ajouterReponsesViaJSON
// Par Mathieu Dumoulin
// Intrant : json = Représente un json contenant toutes les réponses à ajouter
// Description : Cette fonction parcour toutes les réponses contenues dans le json et les ajoutes dans la liste des réponses selon leurs attributs.
function ajouterReponsesViaJSON(json) {
    for(var i = 0; i < json.reponses.length; ++i) {
        ajouterNouvelleReponse(json.reponses[i].estBonneReponse, true);
        // Donne le id ce la réponse dans le input en tant qu'attribut value
        $("#Ul_Reponses li:last-child").children("input[type=text]").attr("value", json.reponses[i].idReponse);
        // Donne l'énonce de la réponse dans le textArea
        $("#Ul_Reponses li:last-child").children(".reponsesQuestion").val(json.reponses[i].enonce);
    }
    // Re aplique les events sur les réponses car lors de la création de nouvelles réponses dynamiquement, ces nouvelles réponses n'ont pas les events.
    addEventsToReponses();
}

// traiterJSONQuestions
// Par Mathieu Dumoulin
// Intrants : resultat : le JSON qu'il faut traiter
// Description : Cette fonction ajoute, pour chacune des rangées contenues dans le json resultat, une question sous forme de 'li' dans le idParent
function traiterJSONQuestions(resultat, idParent) {
    var enonceDeLaQuestion;
    var nomProf;
    var idProprietaire;
    for(var i = 0; i < resultat.length; ++i) {
        enonceDeLaQuestion = resultat[i].enonceQuestion;
        // Je réduit l'énoncé pour qu'elle entre dans une rangé de son li parent pour des questions d'estétisme. 30 à été trouvé par essai/erreur
        if(enonceDeLaQuestion.length > 30) {
            enonceDeLaQuestion = enonceDeLaQuestion.substring(0, 30) + "...";
        }
        nomProf = resultat[i].prenom + " " + resultat[i].nom;
        idProprietaire = resultat[i].idUsager_Proprietaire;
        ajouterLi_AvecDiv(idParent, enonceDeLaQuestion, resultat[i].idQuestion, true, nomProf, "divProfDansLi", idProprietaire);
    }
}

// transformerJSONQuizEnLi
// Par Mathieu Dumoulin
// Intrant : resultat : une chaine de type json contenant une liste de quiz. Le nom des clés correspond au nom des colonnes de la table Quiz.
// Description : Cette fonction ajoute, pour chacune des rangées contenues dans le json resultat, un li représentant un quiz dans la liste des quiz (UlQuiz).
function transformerJSONQuizEnLi(resultat) {
    var titreQuiz = "";
    var idProprietaire = "";
    var nomProprietaire = "";

    if(resultat.length != 0) {
        for(var i = 0; i < resultat.length; ++i) {
            titreQuiz = resultat[i].titreQuiz;
            // Réduit la taille du texte de l'énoncé pour qu'il soit contenable dans une seule rangée d'un li de la liste UlQuiz.
            // Si les caractères sont tous en majuscule, 24 ne suffit pas comme grandeur de texte et il finit par overflow dehors du li.
            // Un overflow:hidden à été ajouté à cet effet pour couvrir ce cas dans le css.
            if(titreQuiz.length > 24) {
                titreQuiz = titreQuiz.substring(0, 24) + "...";
            }
            idProprietaire = resultat[i].idUsager_Proprietaire;
            nomProprietaire = resultat[i].prenom + " " + resultat[i].nom;
            ajouterLi_AvecDiv("UlQuiz", titreQuiz, resultat[i].idQuiz, true ,nomProprietaire, "divProfDansLi", idProprietaire);
        }
    }
    else {
        $("#UlQuiz").text("Ce cours ne contient aucun quiz.");
    }

}
// updateUlQuiz
// Par Mathieu Dumoulin
// Intrants : idCours = identifiant du cours sélectionné courrament dans la DDL_Cours.
//            idProprietaire = identifiant de l'usager propriétaire du quiz
// Description : Cette fonction met à jour (vide et remplis par la suite) la liste de quiz (UlQuiz) à l'aide d'AJAX.
function updateUlQuiz(idCours, idProprietaire) {
    // Enlève le texte contenu dans le UlQuiz (s'il n'y a pas de quiz, un message sous forme de texte apparaît dans l'UlQuiz)
    $("#UlQuiz").text("");
    // Enlève les li enfants de la liste
    $("#UlQuiz li").remove();
    $.ajax({
        type: 'POST',
        url: 'Controleur/listerQuizProf-GererQuiz.php',
        data: {"idCours":idCours , "idProprietaire":idProprietaire},
        dataType: "json",
        success: function(resultat) {
            transformerJSONQuizEnLi(resultat);
            // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
            addClickEventToQuiz();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });

}

// updateUlModifQuiz
// Par Mathieu Dumoulin
// Intrants : triage = Type de triage à appliquer. Voir Controleur/ListerQuestions.php pour connaître les chaines valides.
//            usagerCourant = identifiant de l'usager courant.
//            idQuiz = Identifiant du quiz présent dans le QuizDropZone.
//            filtreEnonce = filtre à appliquer sur l'énoncé des questions. [Optionnel] car parfois pas de filtre.
//            filtreId =  filtre à appliquer sur l'id des questions. [Optionnel] car parfois pas de filtre.
// Description : Cette fonction est très similaire à updateUlQuestion. Différences : Le nombre de paramêtres passés ainsi que le nom du parent.
function updateUlModifQuiz(triage,usagerCourant,idQuiz, filtreEnonce, filtreId) {
    $("#UlModifQuiz li").remove();
    $.ajax({
        type: 'POST',
        url: 'Controleur/ListerQuestions.php',
        data: {"Triage":triage , "idProprietaire":usagerCourant, "idQuiz":idQuiz,
            "filtreEnonce":filtreEnonce, "filtreId":filtreId},
        dataType: "json",
        async:false,
        success: function(resultat) {
            traiterJSONQuestions(resultat, "UlModifQuiz");
            // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
            addClickEventToQuiz(usagerCourant);
            addClickEventToQuestions(usagerCourant);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
// updateUlQuestion
// Par Mathieu Dumoulin
// Intrants : idCours = identifiant du cours qui est sélectionné dans le DDL_Cours.
//            usagerCourant = identifiant de l'usager courant.
//            triage = Type de triage à appliquer. Voir Controleur/ListerQuestions.php pour connaître les chaines valides.
//            idQuiz = Identifiant du quiz présent dans le QuizDropZone. [Optionnel] car parfois il n'y a pas de quiz dans le QuizDropZone.
//            filtreEnonce = filtre à appliquer sur l'énoncé des questions. [Optionnel] car parfois pas de filtre.
//            filtreId =  filtre à appliquer sur l'id des questions. [Optionnel] car parfois pas de filtre.
// Description : Cette fonction met à jour (vide et remplis par la suite) la liste de questions (UlQuestion) selon les paramètres passés.
//               à l'aide de AJAX
function updateUlQuestion(idCours, usagerCourant, triage, idQuiz, filtreEnonce, filtreId) {
    // Retire les li enfants de la liste UlQuestion
    $("#UlQuestion li").remove();

    $.ajax({
        type: 'POST',
        url: 'Controleur/ListerQuestions.php',
        data: {"Triage":triage, "idCours":idCours , "idProprietaire":usagerCourant, "idQuiz":idQuiz, "typeQuiz":"FORMATIF",
                "filtreEnonce":filtreEnonce, "filtreId":filtreId},
        dataType: "json",
        async : false,
        success: function(resultat) {
            traiterJSONQuestions(resultat, "UlQuestion");
            // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
            addClickEventToQuestions(usagerCourant);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

// lierQuestionAQuiz
// Par Mathieu Dumoulin
// Intrants : idQuiz = Identifiant du quiz à lier
//            idQuestion = Identifiant de la question à lier
//            positionQuestion : Position de la question dans le quiz
// Description : Cette fonction fait un appel ajax pour lier la question au quiz à la BD.
function lierQuestionAQuiz(idQuiz, idQuestion, positionQuestion) {
    $.ajax({
        type: "post",
        url: 'Controleur/lierQuizQuestion.php',
        data:  {"idQuiz":idQuiz, "idQuestion":idQuestion, "positionQuestion":positionQuestion},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

// supprimerLienQuestionAQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction fait un appel AJAX pour supprimer le lien d'une question à un quiz dans la BD.
function supprimerLienQuestionAQuiz(idQuiz, idQuestion) {
    $.ajax({
        type: "post",
        url: 'Controleur/supprimerLienQuizQuestion.php',
        data:  {"idQuiz":idQuiz, "idQuestion":idQuestion},
        async:false,
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

// changerOrdreQuestionsDansQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction récupère les questions dans le Ul_ModifQuiz et change leur ordre dans la db à l'aide d'un appel AJAX
function changerOrdreQuestionsDansQuiz() {
    var jsonQuestions = getJSONQuestionDansQuiz();

    $.ajax({
        type: "post",
        url: 'Controleur/changerOrdreQuestionDansQuiz.php',
        data:  {"tableauQuestionsDansQuiz":jsonQuestions},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
// ajouterVariableSessionQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrants: idQuestion = Identifiant représentant la question dans la session
//           etat = Action causant l'ouverture du div dynamique
// Extrant: Il n'y a pas d'extrant
// Description: Cette fonction envoi, à l'aide d'AJAX, les variables passées en paramètre dans la session
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

// ajouterVariableSessionQuiz
// Par Mathieu Dumoulin
// Intrants : idQuiz = identifiant du quiz à passer dans la session
//            etat = action qui est posé lors de l'ouverture d'un quiz (modification ou ajout)
// Description : Cette fonction ajoute, à l'aide d'AJAX, les variables liés à un quiz dans la session
function ajouterVariableSessionQuiz(idQuiz, etat) {
    $.ajax({
        type: "post",
        url: 'Vue/Prof-GererQuiz-AjoutElement.php',
        async:false,
        data:  {"session":true, "idQuiz":idQuiz, "etat":etat},
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


// enleverModificationReponses
// Par Mathieu Dumoulin
// Description : Cette fonction désactive les contrôles liés à la modification d'une réponse
function enleverModificationReponses() {
    // Disable les boutons d'ajout et de suppression de réponse
    $("#reponseConteneur input[type=button]").attr("disabled", "disabled");
    // Disable le bouton d'ordre des réponses et le coche à fixe
    $("#ordreReponsesQuestion").prop("checked",true).attr("disabled", "disabled").button("refresh");
    $("#ordreReponsesQuestion").next("label").children("span").text("Fixe");
    // J'empêche l'usager de modifier le texte des réponses.
    $("#Ul_Reponses li .reponsesQuestion").prop("disabled", "disabled").keydown(function(e) {
        e.preventDefault();
    });
    // Retire la classe .Reponsefocused si elle est encore appliquée.
    $(".Reponsefocused").removeClass("Reponsefocused");

    $("#Ul_Reponses").sortable( "option", "disabled", true );
    $("#Ul_Reponses").sortable("option", "cancel", ".fixed");

}

// permettreModificationReponses
// Par Mathieu Dumoulin
// Description : Cette fonction active les contrôles liés à la modification d'une réponse
function permettreModificationReponses() {
    // Enable les boutons d'ajout et de suppression de réponses
    $("#reponseConteneur input[type=button]").removeAttr("disabled");
    // Enable le bouton d'ordre des réponses
    $("#ordreReponsesQuestion").attr("disabled",false).button("refresh");
    // Je permet à l'usager de modifier le texte des réponses. Ça cancel entre autre le event.preventDefault() qui était bind lors du choix de type Vrai/Faux
    $("#Ul_Reponses li .reponsesQuestion").keydown(function() {
        return true;
    });
}

// ajouterReponsesVraiFaux
// Par Mathieu Dumoulin
// Description : Cette fonction ajoute les réponses vrai/faux dans le #Ul_Reponses
function ajouterReponsesVraiFaux() {
    // Création du frame des réponses vrai/faux
    $.when(ajouterNouvelleReponse(null, true), ajouterNouvelleReponse(null, true)).done( function() {

        $("#Ul_Reponses li").ready(function() {
            // Réponse vrai
            $("#Ul_Reponses li:first-child").children(".reponsesQuestion").val("Vrai");
            $("#Ul_Reponses li:first-child").children("input[type=radio]").attr("value",1);

            // Réponse faux
            $("#Ul_Reponses li:nth-child(2)").children(".reponsesQuestion").val("Faux");
            $("#Ul_Reponses li:nth-child(2)").children("input[type=radio]").attr("value",0);

            enleverModificationReponses();
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
        if($(this).children(".reponsesQuestion").val().trim() == "")  {
            reponsesSontNonVides = false;
        }
        // Si j'ai au moins une réponse qui est Vrai
        if($(this).children("input").prop("checked") == true) {
            uneBonneReponse = true;
        }
    });

    return reponsesSontNonVides && uneBonneReponse;
}

// ajouterNouvelleReponse
// Par Mathieu Dumoulin
// Intrants : estBonneReponse = Un booléen qui définit si ma nouvelle réponse doit être cochée pour dire qu'elle est vrai ou non
//            veutFocus = un booléen qui définit si ma nouvelle réponse doit avoir le focus ou non
// Description : Cette fonction ajoute une nouvelle réponse via PHP à l'aide d'un appel AJAX
function ajouterNouvelleReponse(estBonneReponse, veutFocus) {
    var aCocher;
    if(estBonneReponse == null) {
        // Si je n'ai aucune réponse, je coche cette nouvelle réponse
        $("#Ul_Reponses").children("li").length == 0? aCocher=1 : aCocher=0;
    }
    else {
        estBonneReponse == "true"? aCocher=1 : aCocher=0;
    }
    $.ajax({
        type: "post",
        url: "Vue/Prof-GererQuiz-AjoutElement.php",
        data: {"action":"nouveauInput", "aCocher":aCocher},
        dataType: "html",
        async:false,
        success: function(resultat) {
            // Ajoute ma nouvelle réponse dans la liste des réponses
            $("#Ul_Reponses").append(resultat);
            // rend tous les textArea ajustable en hauteur selon leur contenu
            updateAutoSizeTextArea();
            addEventsToReponses();
            // Donne le focus à la réponse si veutFocus est à true
            if(veutFocus) {
                $("#Ul_Reponses li:last-child").children(".reponsesQuestion").focus();
            }
            // Redistribut le tabIndex dans mon interface car il y a un nouvel élément
            attribuerTabIndexToElemQuestion();

        }
    });
}
// supprimerReponseCourante
// Par Mathieu Dumoulin
// Description :
function supprimerReponseCourante() {
    // Si la classe Reponsefocused à déjà été retirée
    var aRetirerClasseReponsefocused = false;
    // Gestion des erreurs liés à l'interface
    if($("#Ul_Reponses").children("li").length == 1) {
        swal("Oups", "Vous ne pouvez pas avoir de question sans aucune réponse", "error");
    }
    else if($(".Reponsefocused").length == 0) {
        swal("Oups", "Veuillez sélectionner une réponse pour la supprimer.", "warning");
    }
    else {
        // Récupère l'index du li qui possède la classe Reponsefocused
        var indexReponseCourrante = $(".Reponsefocused").parent("li").index();

        var indexNouveauFocus = indexReponseCourrante;
        // Ici == corresponderait au dernier élément de la liste. >= juste pour assurer et prévenir les bugs.
        if(indexNouveauFocus >=  $("#Ul_Reponses").children("li").length - 1) {
            --indexNouveauFocus;
        }

        // .remove() gère automatiquement de supprimer la classe de l'élément (en supprimant l'élément)
        $(".Reponsefocused").parent().remove();
        // Empêche la suppression de la classe Reponsefocused du nouvel élément focus.
        aRetirerClasseReponsefocused = true


        $("#Ul_Reponses").children("li:nth-child(" + (indexNouveauFocus+1) + ")").children(".reponsesQuestion").focus();
    }
    if(!aRetirerClasseReponsefocused)  {
        // Si l'élément a déjà été supprimé, le sélecteur ne va correspondre à aucun élément et cette commande ne va pas être éxécutée.
        $(".Reponsefocused").removeClass("Reponsefocused");
    }
    // Redistribut le tabIndex au travers des éléments de ma question
    attribuerTabIndexToElemQuestion();
}

// cocherCheckBoxCoursSelonQuestion
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Description: Cette fonction communique avec Vue/Prof-GererQuiz-AjoutElement.php en lui passant l'action qu'il veut commettre.
//              Cette page lui renvoie la liste des cours qui comporte la question passée en paramètre sous forme JSON.
//              Par la suite, dans l'attribut success d'AJAX, je coche chacune des CheckBox qui correspondent aux cours renvoyés.
function cocherCheckBoxCoursSelonQuestion(idQuestion) {
    $.ajax({
        type:"POST",
        url:'Vue/Prof-GererQuiz-AjoutElement.php',
        data: {"action":"listeCoursSelonQuestion", "idQuestion": idQuestion },
        dataType: "json",
        success: function(resultat){
            for(var i = 0; i < resultat.length; ++i) {
                // Parcours tous les cours de ma liste de cours
                $("#listeAjoutCours input[type=checkbox]").each(function(){
                    // Si ça correspond à un cours qui est coché dans la bd
                    if($(this).attr("value") == resultat[i].idCours) {
                        // Coche le dans l'interface
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

// cocherCheckBoxCoursSelonQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction communique avec Vue/Prof-GererQuiz-AjoutElement.php en lui passant l'action qu'il veut commettre.
//              Cette page lui renvoie la liste des cours qui comporte le quiz passé en paramètre sous forme JSON.
//              Par la suite, dans l'attribut success d'AJAX, je coche chacune des CheckBox qui correspondent aux cours renvoyés.
function cocherCheckBoxCoursSelonQuiz(idQuiz) {
    $.ajax({
        type:"POST",
        url:'Vue/Prof-GererQuiz-AjoutElement.php',
        data: {"action":"listeCoursSelonQuiz", "idQuiz": idQuiz },
        dataType: "json",
        success: function(resultat){
            for(var i = 0; i < resultat.length; ++i) {
                // Parcours tous les cours de ma liste de cours
                $("#listeCoursQuiz input[type=checkbox]").each(function(){
                    // Si ça correspond à un cours qui est coché dans la bd
                    if($(this).attr("value") == resultat[i].idCours) {
                        // Coche le dans l'interface
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

// cocherCheckBoxCoursSelonCoursCourant
// Par Mathieu Dumoulin
// Date: 24/10/2014
// Intrants: idUl = l'identifiant de la liste parente de l'objet à cocher
// Description: Parcours la liste des cours  enfant du parent idUl et coche le cours qui correspond au cours sélectionné du DDL_Cours
function cocherCheckBoxCoursSelonCoursCourant(idUl) {
    // Parcours chacun des checkbox de la liste parente
    $("#" + idUl + " li").children("input[type=checkbox]").each( function() {
        // Si le checkbox correspond au cours sélectionné
       if($(this).attr("value") == $("#DDL_Cours option:selected").attr("value")) {
           // Coche le
           $(this).prop('checked', true);
       }
    });
}

// cocherRadioButtonAvecValeur
// Par Mathieu Dumoulin
// Intrants: valeur = la valeur du radio button qui doit être coché
// Description: Parcours la liste des types de question et coche le type de question qui correspond à la valeur passée en paramètre
function cocherRadioButtonAvecValeur(valeur){
    $("#TypeQuestion li").children("input[type=radio]").each( function() {
        // Si l'élément courant correspond à la valeur
        if($(this).attr("value") == valeur) {
            // Coche le
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
        // Si mon checkbox correspond à un typeQuiz qui est coché
        for(var i = 0; i < typeQuiz.length; ++i) {
            if($(this).attr("value") == typeQuiz[i].typeQuiz) {
                // Je le coche
                $(this).prop('checked', true);
            }
        }
    });
}

// cocherTypeQuizAssocieParDefaut
// Par Mathieu Dumoulin
// Description : Coche tous les checkbox enfant de la liste qui a pour id idParent
function cocherTypeQuizAssocieParDefaut(idParent) {
    $("#" + idParent).children("li").each(function() {
        $(this).children("input[type=checkbox]").prop("checked", true);
    });
}

// getJSONQuestionDansQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction prend le quiz dans le QuizDropZone et les questions que ce quiz contient dans l'interface et transpose le tout
//               sous forme de JSON.
function getJSONQuestionDansQuiz() {
    // Structure initiale de mon JSON: l'id du quiz ainsi qu'un tableau 2 dimension comportant les questions de ce quiz.
    var jsonQuestions = '[{"idQuiz":"' + $("#QuizDropZone li:first-child").attr("id") + '"},' +
                       '{"questions":[';

    // Parcours chacune des questions, prend leur identifiant ainsi que leur position dans la liste (au cas si les questions sont en ordre fixe dans le quiz)
    $("#UlModifQuiz li").each(function() {
        jsonQuestions += '{"idQuestion":"' + $(this).attr("id") + '", "positionQuestion":"' + ($(this).index() +1)  +'"},'
    });

    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#UlModifQuiz li").length > 0) {
        jsonQuestions = jsonQuestions.substr(0,jsonQuestions.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    jsonQuestions += "]}]";
    // Je transforme la string en JSON
    jsonQuestions = JSON.parse(jsonQuestions);

    return jsonQuestions;
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
        var enonce = $(this).children(".reponsesQuestion").val();
        enonce = modifierChainePourJSON(enonce);

        // Rend les guillemets en caractère litéraire ce qui empêche les bugs dans le traitement de la chaine. (La chaine est entourée de base d'une paire de guillements)
        reponsesEnString += '{"enonce":"'+enonce +'", "estBonneReponse":"' + estCoche + '",' +
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

// jsonifierCoursSelectionnes
// Par Mathieu Dumoulin
// Description : Cette fonction prend tous les checkbox enfant de l'élément à identifiant idUlParent
// et les transpose dans un JSON contenant des cours.
function jsonifierCoursSelectionnes(idUlParent) {

    // Ouverture du string de format JSON
    var coursEnString = '{"cours":[';

    // Pour chacun de mes cours, je vérifie lesquels sont cochés et je prend leur énoncé.
    // Par la suite, j'ajoute mon cours sous forme d'une rangée dans mon string de format JSON
    $("#" + idUlParent +" li").each( function() {
        if($(this).children("input[type=checkbox]").prop("checked") == true) {
            // Rend les guillemets en caractère litéraire ce qui empêche les bugs dans le traitement de la chaine. (La chaine est entourée de base d'une paire de guillements)
            coursEnString += '{"nomCours":"'+$(this).text().replace(/[\"]/g, '\\"')+'", "idCours":"'+ $(this).children("input[type=checkbox]").attr("value") + '"},';
        }
    });
    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#" + idUlParent +" li input:checkbox:checked").length > 0) {
        coursEnString = coursEnString.substr(0,coursEnString.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    coursEnString += "]}";
    // Je transforme mon string de format JSON en objet JSON
    var jsonCours = JSON.parse(coursEnString);

    return jsonCours;
}

// jsonifierTypeQuizAssQuestionCourante
// Par Mathieu Dumoulin
// Description : Cette fonction prend tous les checkbox enfant de l'élément à identifiant idUlParent
// et les transpose dans un JSON contenant les types de quiz.
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

// getJSONEnonceQuestion
// Par Mathieu Dumoulin
// Description : Récupères les éléments propre à une question ( son énoncé, son propriétaire, le lienWeb,
//               l'ordre de ces réponses ainsi que son identifiant (si c'est une modification de question)
function getJSONEnonceQuestion(idCreateur, idQuestion ) {
    // Récupère l'énoncé
    var enonce = $("#EnonceQuestion").val();

    enonce = modifierChainePourJSON(enonce);
    // Création du string qui va devenir un JSON
    var jsonQuestion = '{"enonceQuestion" : "' + enonce + '", "idUsager_Proprietaire":"' + idCreateur + '", "lienWeb":"'
                       + encodeURI($("#conteneurLienWeb input[type=text]").val()) + '", "ordreReponsesAleatoire":"' + !$("#ordreReponsesQuestion").prop("checked") + '"';
    if(idQuestion != null) {
        jsonQuestion +=', "idQuestion":"'+ idQuestion+'"';
    }
    jsonQuestion += '}';
    // Transforme le string en JSON
    jsonQuestion = JSON.parse(jsonQuestion);

    return jsonQuestion;
}

// modifierChainePourJSON
// Par Mathieu Dumoulin
// Description : Transforme la chaine de caractère pour qu'il n'y ai pas de conflits avec les guillemets, new lines et
//               pas de blancs aux extrémités  de cette chaine.
function modifierChainePourJSON(chaine) {
    // Gère les backslash pour qu'ils ne soient plus des caractères d'échappement (escape caracter)
    chaine = chaine.replace(/[\\]/g, '\\\\');
    // Rend littéraire les new lines (\n), les guillemets (") de la chaine ainsi que les blancs qui sont à ses extrémités
    return chaine.replace(/[\"]/g, '\\"').replace(/[\n]/g, '\\n').trim();
}

// ajouterQuestion
// Par Mathieu Dumoulin
// Intrants : idCreateur = Identifiant de l'usager qui veut ajouter la question
// Description : Cette fonction récupère les éléments de l'interface dynamique-GererQuestion et les envois par AJAX au PHP
//               pour qu'il ajoute la quesiton dans la base de données.
function ajouterQuestion(idCreateur, continuer) {
    if( reponsesSontValides()) {
        // Récupère les éléments en lien avec la question dans l'interface dynamique-GererQuestion
        var jsonQuestion = getJSONEnonceQuestion(idCreateur);
        var jsonReponses = jsonifierReponsesQuestionCourante();
        var jsonCours = jsonifierCoursSelectionnes("listeAjoutCours");
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
                // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
                if(resultat.trim() != "") {
                    swal("Erreur !", resultat, "error");
                }
                else {
                    // Retire le keydown ajouter à l'ouverture du div dynamique
                    $(document).off("keydown");
                    // Si ce n'est pas ajouter et continuer
                    if(continuer == null) {
                        fermerDivDynamique();
                    }
                    else {
                        // Sinon je reinitialise le contenu de ma page "Vue/dynamique-GererQuestion.php"
                        viderHTMLfromElement("popupPrincipal");
                        insererHTMLfromPHP("popupPrincipal", "Vue/dynamique-GererQuestion.php");
                    }

                    // Je "refresh" la page Prof-GererQuiz pour qu'elle d'ajuste à l'ajout
                    var cours = $("#DDL_Cours option:selected").attr("value");
                    var filtreEnonce = $("#TB_Filtre").val();
                    var filtreId = $("#TB_FiltreID").val();

                    // Gestion de l'affichage des questions dans les listes
                    // S'il n'y a pas de quiz en train d'être modifié
                    if($("#QuizDropZone").children("li").length == 0) {
                        // Refresh seulement la liste des questions
                        updateUlQuestion( cours, idCreateur, "default", "", filtreEnonce, filtreId);
                    }
                    else {
                        // Sinon, refresh la liste des questions et l'affichage du contenu du quiz
                        var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                        updateUlQuestion(cours, idCreateur, "pasDansCeQuiz", idQuiz, filtreEnonce, filtreId);
                        updateUlModifQuiz("selonQuiz", idCreateur, idQuiz);
                    }
                    swal("Félicitation !", "Votre question à été ajoutée", "success");
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
// modifierQuestion
// Par Mathieu Dumoulin
// Intrants : idUsagerCourant = Identifiant de l'usager qui veut modifier la question
//            idQuestion = Identifiant de la question à modifier
//            idProprietaire = Identifiant du propriétaire de la question
// Description : Cette fonction récupère les éléments de l'interface dynamique-GererQuestion et les envois par AJAX au PHP
//               pour qu'il modifie la quesiton dans la base de données.
function modifierQuestion( idUsagerCourant,idQuestion, idProprietaire) {

    if(idUsagerCourant != idProprietaire) {
        swal("Avertissement",
            "Vous ne pouvez pas modifier cette question car vous n'êtes pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la modifier.",
            "error" );
    }
    else if(reponsesSontValides()) {
        // Récupère les éléments en lien avec la question dans l'interface dynamique-GererQuestion
        var jsonQuestion = getJSONEnonceQuestion(idUsagerCourant, idQuestion);
        var jsonReponses = jsonifierReponsesQuestionCourante();
        var jsonCours = jsonifierCoursSelectionnes("listeAjoutCours");
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
                // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
                if(resultat.trim() != "") {
                    swal("Erreur !", resultat, "error");
                }
                else {
                    // Retire le keydown ajouter à l'ouverture du div dynamique
                    $(document).off("keydown");
                    // S'il n'y a pas eu d'erreur
                    // Je ferme le div dynamique
                    fermerDivDynamique();
                    // Et je met à jour la page Prof-GererQuiz pour qu'elle représente le contenu réel de la base de données
                    var cours = $("#DDL_Cours option:selected").attr("value");
                    var filtreEnonce = $("#TB_Filtre").val();
                    var filtreId = $("#TB_FiltreID").val();

                    // Gestion de l'affichage des questions dans les listes
                    // S'il n'y a pas de quiz en train d'être modifié
                    if($("#QuizDropZone").children("li").length == 0) {
                        // Refresh seulement la liste des questions
                        updateUlQuestion( cours, idUsagerCourant, "default", "", filtreEnonce,filtreId);
                    }
                    else {
                    // Sinon, refresh la liste des questions et l'affichage du contenu du quiz
                        var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                        updateUlQuestion(cours, idUsagerCourant, "pasDansCeQuiz", idQuiz, filtreEnonce,filtreId);
                        updateUlModifQuiz("selonQuiz", idUsagerCourant, idQuiz);
                    }
                    swal("Félicitation !", "Votre question à été modifiée", "success");
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
// fermerDivDynamique
// Par Mathieu Dumoulin
function fermerDivDynamique() {
    $(".dFondOmbrage").detach();
}

// supprimerQuestion
// Par Mathieu Dumoulin
// Intrants : idUsagerCourant = Identifiant de l'usager qui veut modifier la question
//            idQuestion = Identifiant de la question à modifier
//            idProprietaire = Identifiant du propriétaire de la question
// Description : Cette fonction envoi l'identifiant de la question par AJAX au PHP pour qu'il supprime la quesiton dans la base de données.
function supprimerQuestion(idUsagerCourant, idQuestion, idProprietaire) {
    if(idUsagerCourant != idProprietaire) {
        swal("Avertissement",
            "Vous ne pouvez pas supprimer cette question car vous n'êtes pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la supprimer.",
            "error" );
    }
    else {
        // Confirmation de l'usager pour supprimer la question
        swal({   title: "Êtes-vous sur?",
            text: "Cette action va supprimer cette question ainsi que toutes les références à cette question. Êtes-vous sur de vouloir continuer?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer cette question",
            closeOnConfirm: false
        }, function(aAccepter){
            // Si l'usager a accepté, fait un appel AJAX pour supprimer
            if(aAccepter) {
                $.ajax({
                    type:"POST",
                    url:'Controleur/supprimerUneQuestion.php',
                    async : false,
                    data: {"idQuestion":idQuestion},
                    dataType: "text",
                    success: function(resultat){
                        // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
                        if(resultat.trim() != "") {
                            swal("Erreur !", resultat, "error");
                        }
                        else {
                            // Retire le keydown ajouter à l'ouverture du div dynamique
                            $(document).off("keydown");
                            // S'il n'y a pas eu d'erreur
                            // Je ferme le div dynamique
                            fermerDivDynamique();

                            // Et je met à jour la page Prof-GererQuiz pour qu'elle représente le contenu réel de la base de données
                            var cours = $("#DDL_Cours option:selected").attr("value");
                            var filtreEnonce = $("#TB_Filtre").val();
                            var filtreId = $("#TB_FiltreID").val();

                            // Gestion de l'affichage des questions dans les listes
                            // S'il n'y a pas de quiz en train d'être modifié
                            if($("#QuizDropZone").children("li").length == 0) {
                                // Refresh seulement la liste des questions
                                updateUlQuestion( cours, idUsagerCourant, "default", "",filtreEnonce, filtreId);
                            }
                            else {
                            // Sinon, refresh la liste des questions et l'affichage du contenu du quiz
                                var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                                updateUlQuestion(cours, idUsagerCourant, "pasDansCeQuiz", idQuiz, filtreEnonce, filtreId);
                                updateUlModifQuiz("selonQuiz", idUsagerCourant, idQuiz);
                            }
                            swal("Félicitation !", "Votre question à été supprimée", "success");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
                    }
                });
            }
        });

    }
}

// ajouterQuiz
// Par Mathieu Dumoulin
// Intrant : idUsagerProprietaire = Identifiant de l'usager qui créé le quiz
// Description :  Cette fonction récupère les éléments de l'interface dynamique-GererQuiz et les envois par AJAX au PHP
//               pour qu'il ajoute le quiz dans la base de données.
function ajouterQuiz(idUsagerProprietaire) {
    // Prise du titre du quiz dans l'interface.
    var titreQuiz = $("#titreQuiz").val();
    // Prise de l'ordre des question
    var ordreEstAleatoire = !$("#ordreQuestionQuiz").prop("checked");
    // Prise de la disponibilité du quiz
    var estDisponible = !$("#disponibiliteQuiz").prop("checked");
    // Prise des cours sélectionnés
    var jsonCours = jsonifierCoursSelectionnes("listeCoursQuiz");

    $.ajax({
        type:"POST",
        url:'Controleur/AJAX_AjouterQuiz.php',
        async : false,
        data: {"titreQuiz":titreQuiz, "ordreEstAleatoire":ordreEstAleatoire, "estDisponible":estDisponible, "jsonCours":jsonCours, "idProprietaire":idUsagerProprietaire},
        dataType: "text",
        success: function(resultat){
            // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
            if(resultat.trim() != "") {
                swal("Erreur !", resultat, "error");
            }
            else {
                // Retire le keydown ajouter à l'ouverture du div dynamique
                $(document).off("keydown");
                swal("Félicitation !", "Votre quiz à été ajouté", "success");
                fermerDivDynamique();
                // Je met à jour la page Prof-GererQuiz pour qu'elle représente le contenu réel de la base de données
                var idCours = $("#DDL_Cours option:selected").attr("value");
                updateUlQuiz(idCours, idUsagerProprietaire);
                // Je retire le quiz qui est en cours de modification pour simplifier le listage.
                retirerQuizDeQuizDropZone(idCours, idUsagerProprietaire);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
        }
    });
}

// modifierQuiz
// Par Mathieu Dumoulin
// Intrants : idQuiz = Identifiant du quiz à modifier
//            idUsagerCourant = Identifiant de l'usager qui essaye de modifier le quiz
//            idProprietaire = Identifiant de l'usager propriétaire du quiz
// Description : Cette fonction récupère les éléments de l'interface dynamique-GererQuiz et les envois par AJAX au PHP
//               pour qu'il modifie le quiz dans la base de données.
function modifierQuiz(idQuiz, idUsagerCourant, idProprietaire) {
    if(idProprietaire != idUsagerCourant) {
        swal("Avertissement",
            "Vous ne pouvez pas modifier ce quiz car vous n'êtes pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la modifier.",
            "error" );
    }
    else {
        // Prise du titre du quiz dans l'interface.
        var titreQuiz = $("#titreQuiz").val();
        // Prise de l'ordre des question
        var ordreEstAleatoire = !$("#ordreQuestionQuiz").prop("checked");
        // Prise de la disponibilité du quiz
        var estDisponible = !$("#disponibiliteQuiz").prop("checked");
        // Prise des cours sélectionnés
        var jsonCours = jsonifierCoursSelectionnes("listeCoursQuiz");

        $.ajax({
            type:"POST",
            url:'Controleur/AJAX_ModifierQuiz.php',
            async : false,
            data: {"idQuiz":idQuiz, "titreQuiz":titreQuiz, "ordreEstAleatoire":ordreEstAleatoire, "estDisponible":estDisponible, "jsonCours":jsonCours, "idProprietaire":idUsagerCourant},
            dataType: "text",
            success: function(resultat){
                // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
                if(resultat.trim() != "") {
                    swal("Erreur !", resultat, "error");
                }
                else {
                    // Retire le keydown ajouter à l'ouverture du div dynamique
                    $(document).off("keydown");
                    swal("Félicitation !", "Votre quiz à été modifié", "success");
                    fermerDivDynamique();
                    // Je met à jour la page Prof-GererQuiz pour qu'elle représente le contenu réel de la base de données
                    var idCours = $("#DDL_Cours option:selected").attr("value");
                    updateUlQuiz(idCours, idUsagerCourant);
                    // Je retire le quiz qui est en cours de modification pour simplifier le listage.
                    retirerQuizDeQuizDropZone(idCours, idUsagerCourant);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
            }
        });
    }

}

// supprimerQuiz
// Par Mathieu Dumoulin
// Intrants : idQuiz = Identifiant du quiz à modifier
//            idUsagerCourant = Identifiant de l'usager qui essaye de modifier le quiz
//            idProprietaire = Identifiant de l'usager propriétaire du quiz
// Description : Cette fonction envoie par AJAX l'identifiant du quiz pour que le PHP supprime ce quiz dans la base de données.
function supprimerQuiz(idQuiz, idUsagerCourant, idProprietaire) {
    // Si l'usager ne dispose pas des droits de suppression sur le quiz
    if(idProprietaire != idUsagerCourant) {
        swal("Avertissement",
            "Vous ne pouvez pas supprimer ce quiz car vous n'êtes pas le propriétaire. Veuillez contacter le propriétaire si vous voulez le supprimer.",
            "error" );
    }
    else {
        // Demande de confirmation avant suppression
        swal({   title: "Êtes-vous sur?",
            text: "Cette action va supprimer ce quiz ainsi que toutes ces références. Êtes-vous sur de vouloir continuer?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer ce quiz",
            closeOnConfirm:false
        }, function(aAccepter){
            // Si l'usager a confirmé la suppression
            if(aAccepter) {
                $.ajax({
                    type:"POST",
                    url:'Controleur/AJAX_SupprimerQuiz.php',
                    async : false,
                    data: {"idQuiz":idQuiz},
                    dataType: "text",
                    success: function(resultat){
                        // Gestion des erreurs si j'en ai trouvés par programmation dans le fichier php
                        if(resultat.trim() != "") {
                            swal("Erreur !", resultat, "error");
                        }
                        else {
                            // Retire le keydown ajouter à l'ouverture du div dynamique
                            $(document).off("keydown");
                            $(".dFondOmbrage").detach();
                            var cours = $("#DDL_Cours option:selected").attr("value");
                            // Impossible pour l'instant car on à empêcher la modification/supression du quiz qui est dans le QuizDropZone.
                            if($("#QuizDropZone").children("li").length == 1 && $("#QuizDropZone").children("li").attr("id") == idQuiz) {

                            }
                            else {
                                updateUlQuiz(cours, idUsagerCourant);
                            }
                            // Retire le quiz qui est en cour de modification et met à jour les listes de questions
                            retirerQuizDeQuizDropZone(cours, idUsagerCourant);
                            swal("Félicitation !", "Votre quiz à été supprimée", "success");
                        }
                    }
                });
            }
        });
    }
}

// retirerQuizDeQuizDropZone
// Par Mathieu Dumoulin
// Intrants : idCours = Identifiant du cours qui est sélectionné dans le DDL_Cours
//            idUsagerCourrant = Identifiant de l'usager qui est connecté en se moment.
// Description : Cette fonction retire le quiz du QuizDropZone et met à jours les listes de questions.
function retirerQuizDeQuizDropZone(idCours, idUsagerCourrant) {
    // Retire le quiz qui est en cour de modification
    updateUlQuestion(idCours, idUsagerCourrant,  "default");
    $("#QuizDropZone").children("li").remove();
    $("#UlModifQuiz").empty();
}

function verifierEgalite(premiereVar, deuxiemeVar) {
    return premiereVar == deuxiemeVar;
}

// attribuerTabIndexToElemQuestion
// Par Mathieu Dumoulin
// Description : Cette fonction attribut le tabIndex aux éléments de la page.
//               Pourquoi le faire en javascript et non en html?
//               Réponse : Le nombre d'éléments dans la page varie (nombre de réponses) alors tous les contrôles ont un tabIndex qui doit changer
function attribuerTabIndexToElemQuestion() {
    // L'enonce possède déjà le tabIndex 1
    var tabIndex = 1;
    // Attribut un tabIndex à toutes les réponses
    $("#Ul_Reponses li").each(function() {
        $(this).children("textarea").attr("tabIndex", ++tabIndex);
    });

    $("#BTN_SupprimerQuestion").attr("tabIndex", ++tabIndex);
    $("#BTN_ConfirmerQuestion").attr("tabIndex", ++tabIndex);
    $("#BTN_ContinuerAjout").attr("tabIndex", ++tabIndex);
}
