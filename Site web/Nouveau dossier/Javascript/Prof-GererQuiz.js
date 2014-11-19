// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


function addClickEventToQuestions(usagerCourant) {
    $("#UlQuestion li, #UlModifQuiz li").off("click");
    $("#UlQuestion li, #UlModifQuiz li").click( function() {
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

function addClickEventToQuiz() {
    $("#UlQuiz li, #UlModifQuiz li").off("click");
    $("#UlQuiz li, #UlModifQuiz li").click( function() {
        ajouterVariableSessionQuiz($(this).attr("id"), "modifierQuiz");

        creeFrameDynamique("divDynamiqueQuiz", "Vue/dynamique-GererQuiz.php");

    });
}

function addEventsToReponses() {
    $(".reponsesQuestion").off("focusin").off("focusout");
    $(".reponsesQuestion").focusin(function() {
        $(this).addClass("Reponsefocused");
    }).focusout(function(event) {
        if($(event.relatedTarget).attr("id") != "BTN_SupprimerReponse") {
            $(this).removeClass("Reponsefocused");
        }
    });

    $(".reponsesQuestion").off("keydown");
    $(".reponsesQuestion").keydown(function(e) {
        // Si c'est shift+enter qui est appuyer
        if(e.shiftKey == true ) {

            if(e.which == 13) {
                $("#BTN_AjouterReponse").click();
                e.preventDefault();
            }
            else if(e.which == 46) {
                $("#BTN_SupprimerReponse").click();
                e.preventDefault();
            }
        }
        else if(e.ctrlKey == true && e.which != 17) {
            // alert(e.which);  todo à implémenter le promenage avec flèche dans les réponses
        }
    });

}

function updateAutoSizeTextArea() {
    $('textarea').each(function () {
        h(this);
    }).on('input', function () {
        h(this);
    });
}

function ajouterReponsesViaJSON(json) {
    for(var i = 0; i < dictionnaireReponsesChoixMulti.reponses.length; ++i) {
        ajouterNouvelleReponse(json.reponses[i].estBonneReponse);
        $("#Ul_Reponses li:last-child").children("input[type=text]").attr("value", json.reponses[i].idReponse);
        $("#Ul_Reponses li:last-child").children(".reponsesQuestion").val(json.reponses[i].enonce);
    }
    addEventsToReponses();
}

function traiterJSONQuestions(resultat, idParent) {
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
        ajouterLi_AvecDiv(idParent, enonceDeLaQuestion, resultat[i].idQuestion, true, nomProf, "divProfDansLi", idProprietaire);
    }
}

function traiterJSONQuiz(resultat) {
    var titreQuiz = "";
    var typeQuiz = "";

    if(resultat.length != 0) {
        for(var i = 0; i < resultat.length; ++i) {
            titreQuiz = resultat[i].titreQuiz;
            if(titreQuiz.length > 24) {
                titreQuiz = titreQuiz.substring(0, 24) + "...";
            }
            typeQuiz = resultat[i].typeQuiz;
            ajouterLi_AvecDiv("UlQuiz", titreQuiz, resultat[i].idQuiz, true, typeQuiz, "divProfDansLi");
        }
    }
    else {
        $("#UlQuiz").text("Vous ne disposez d'aucun quiz pour ce cours.");
    }

}

function updateUlQuiz(idCours, idProprietaire) {
    $("#UlQuiz").text("");
    $("#UlQuiz li").remove();
    $.ajax({
        type: 'POST',
        url: 'Controleur/listerQuizProf-GererQuiz.php',
        data: {"idCours":idCours , "idProprietaire":idProprietaire},
        dataType: "json",
        success: function(resultat) {
            traiterJSONQuiz(resultat);

            // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
            addClickEventToQuiz();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });

}

function updateUlModifQuiz(triage,usagerCourant,idQuiz, filtreEnonce) {
    $("#UlModifQuiz li").remove();
    $.ajax({
        type: 'POST',
        url: 'Controleur/ListerQuestions.php',
        data: {"Triage":triage , "idProprietaire":usagerCourant, "idQuiz":idQuiz, "filtreEnonce":filtreEnonce},
        dataType: "json",
        async:false,
        success: function(resultat) {
            traiterJSONQuestions(resultat, "UlModifQuiz");
            // En retirant les anciens li, l'ancien événement click est détruit donc on doit le recréer.
            addClickEventToQuestions(usagerCourant);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function updateUlQuestion(idCours, usagerCourant, triage, idQuiz, typeQuiz, filtreEnonce) {
    $("#UlQuestion li").remove();
    $.ajax({
        type: 'POST',
        url: 'Controleur/ListerQuestions.php',
        data: {"Triage":triage, "idCours":idCours , "idProprietaire":usagerCourant, "idQuiz":idQuiz, "typeQuiz":typeQuiz,
                "filtreEnonce":filtreEnonce},
        dataType: "json",
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

function supprimerLienQuestionAQuiz(idQuiz, idQuestion) {
    $.ajax({
        type: "post",
        url: 'Controleur/supprimerLienQuizQuestion.php',
        data:  {"idQuiz":idQuiz, "idQuestion":idQuestion},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

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
    // J'empêche l'usager de modifier le texte des réponses.
    $("#Ul_Reponses li .reponsesQuestion").keydown(function(e) {
        e.preventDefault();
    });
}

// permettreModificationReponses
// Par Mathieu Dumoulin
// Description : Cette fonction active les contrôles liés à la modification d'une réponse
function permettreModificationReponses() {
    // Enable les boutons d'ajout et de suppression de réponses
    $("#reponseConteneur input[type=button]").removeAttr("disabled");
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
    $.when(ajouterNouvelleReponse(), ajouterNouvelleReponse()).done( function() {

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


function ajouterNouvelleReponse(estBonneReponse) {
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
            $("#Ul_Reponses").append(resultat);
            updateAutoSizeTextArea();
            addEventsToReponses();
            $("#Ul_Reponses li:last-child").children(".reponsesQuestion").focus();

        }
    });
}

function supprimerReponseCourante() {
    var aRetirerClasseReponsefocused = false;
    if($("#Ul_Reponses").children("li").length == 1) {
        swal("Oups", "Vous ne pouvez pas avoir de question sans aucune réponse", "error");
    }
    else if($(".Reponsefocused").length == 0) {
        swal("Oups", "Veuillez sélectionner une réponse pour la supprimer.", "warning");
    }
    else {
        var indexReponseCourrante = $(".Reponsefocused").parent("li").index();

        var indexNouveauFocus = indexReponseCourrante;
        // Ici == corresponderait au dernier élément de la liste. >= juste pour assurer et prévenir les bugs.
        if(indexNouveauFocus >=  $("#Ul_Reponses").children("li").length - 1) {
            --indexNouveauFocus;
        }

        // .remove() gère automatiquement de supprimer la classe de l'élément (en supprimant l'élément)
        $(".Reponsefocused").parent().remove();
        // Empêche la suppression de la classe Reponsefocused du nouvel élément focus.
        aSupprimerClasseReponsefocused = true


        $("#Ul_Reponses").children("li:nth-child(" + (indexNouveauFocus+1) + ")").children(".reponsesQuestion").focus();
    }
    if(!aSupprimerClasseReponsefocused)  {
        // Si l'élément a déjà été supprimé, le sélecteur ne va correspondre à aucun élément et cette commande ne va pas être éxécutée.
        $(".Reponsefocused").removeClass("Reponsefocused");
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

function cocherCheckBoxCoursSelonQuiz(idQuiz) {
    $.ajax({
        type:"POST",
        url:'Vue/Prof-GererQuiz-AjoutElement.php',
        data: {"action":"listeCoursSelonQuiz", "idQuiz": idQuiz },
        dataType: "json",
        success: function(resultat){
            for(var i = 0; i < resultat.length; ++i) {
                $("#listeCoursQuiz input[type=checkbox]").each(function(){
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
function cocherCheckBoxCoursSelonCoursCourant(idUl) {
    $("#" + idUl + " li").children("input[type=checkbox]").each( function() {
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


function getJSONQuestionDansQuiz() {
    var jsonQuestions = '[{"idQuiz":"' + $("#QuizDropZone li:first-child").attr("id") + '"},' +
                       '{"questions":[';

    $("#UlModifQuiz li").each(function() {
        jsonQuestions += '{"idQuestion":"' + $(this).attr("id") + '", "positionQuestion":"' + ($(this).index() +1)  +'"},'
    });

    // J'enlève la dernière virgule de mon string car, en JSON, le dernier élément ne prend pas de virgule
    if($("#UlModifQuiz li").length > 0) {
        jsonQuestions = jsonQuestions.substr(0,jsonQuestions.length -1);
    }
    // Je ferme par la suite mon string de format JSON
    jsonQuestions += "]}]";
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
    var enonce = $("#EnonceQuestion").val();

    enonce = modifierChainePourJSON(enonce);

    var jsonQuestion = '{"enonceQuestion" : "' + enonce + '", "idUsager_Proprietaire":"' + idCreateur + '", "lienWeb":"'
                       + $("#conteneurLienWeb input[type=text]").val() + '", "ordreReponsesAleatoire":"' + !$("#ordreReponsesQuestion").prop("checked") + '"';
    if(idQuestion != null) {
        jsonQuestion +=', "idQuestion":"'+ idQuestion+'"';
    }
    jsonQuestion += '}';
    jsonQuestion = JSON.parse(jsonQuestion);

    return jsonQuestion;
}

function modifierChainePourJSON(chaine) {
    // Rend littéraire les new lines (\n), les guillemets (") de la chaine ainsi que les blancs qui sont à ses extrémités
    return chaine.replace(/[\"]/g, '\\"').replace(/[\n]/g, '\\n').trim();
}

function ajouterQuestion(idCreateur, continuer) {
    if( reponsesSontValides()) {
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
                if(resultat.trim() != "") {
                    swal("Erreur !", resultat, "error");
                }
                else {
                    if(continuer == null) {
                        $(".dFondOmbrage").detach();
                    }
                    else {
                        viderHTMLfromElement("popupPrincipal");
                        insererHTMLfromPHP("popupPrincipal", "Vue/dynamique-GererQuestion.php");
                    }

                    var cours = $("#DDL_Cours option:selected").attr("value");

                    // Gestion de l'affichage des questions dans les listes
                    if($("#QuizDropZone").children("li").length == 0) {
                        updateUlQuestion( cours, idCreateur, "default");
                    }
                    else {
                        var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                        var typeQuiz = $("#QuizDropZone li:first-child").children("div .divProfDansLi").text();
                        updateUlQuestion(cours, idCreateur, "pasDansCeQuiz", idQuiz, typeQuiz);
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

function modifierQuestion( idUsagerCourant,idQuestion, idProprietaire) {

    if(idUsagerCourant != idProprietaire) {
        swal("Avertissement",
            "Vous ne pouvez pas modifier cette question car vous n'êtes  pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la modifier.",
            "error" );
    }
    else if(reponsesSontValides()) {
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
                if(resultat.trim() != "") {
                    swal("Erreur !", resultat, "error");
                }
                else {
                    $(".dFondOmbrage").detach();
                    var cours = $("#DDL_Cours option:selected").attr("value");
                    // Gestion de l'affichage des questions dans les listes
                    if($("#QuizDropZone").children("li").length == 0) {
                        updateUlQuestion( cours, idUsagerCourant, "default");
                    }
                    else {
                        var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                        var typeQuiz = $("#QuizDropZone li:first-child").children("div .divProfDansLi").text();
                        updateUlQuestion(cours, idUsagerCourant, "pasDansCeQuiz", idQuiz, typeQuiz);
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

function fermerDivDynamique() {
    $(".dFondOmbrage").detach();
}

function supprimerQuestion(idUsagerCourant, idQuestion, idProprietaire) {
    if(idUsagerCourant != idProprietaire) {
        swal("Avertissement",
            "Vous ne pouvez pas supprimer cette question car vous n'êtes  pas le propriétaire. Veuillez contacter le propriétaire si vous voulez la supprimer.",
            "error" );
    }
    else {
        swal({   title: "Êtes-vous sur?",
            text: "Cette action va supprimer cette question ainsi que toutes les références à cette question. Êtes-vous sur de vouloir continuer?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer cette question",
            closeOnConfirm: false
        }, function(aAccepter){
            if(aAccepter) {
                $.ajax({
                    type:"POST",
                    url:'Controleur/supprimerUneQuestion.php',
                    async : false,
                    data: {"idQuestion":idQuestion},
                    dataType: "text",
                    success: function(resultat){
                        if(resultat.trim() != "") {
                            swal("Erreur !", resultat, "error");
                        }
                        else {
                            $(".dFondOmbrage").detach();
                            var cours = $("#DDL_Cours option:selected").attr("value");

                            // Gestion de l'affichage des questions dans les listes
                            if($("#QuizDropZone").children("li").length == 0) {
                                updateUlQuestion( cours, idUsagerCourant, "default");
                            }
                            else {
                                var idQuiz = $("#QuizDropZone li:first-child").attr("id");
                                var typeQuiz = $("#QuizDropZone li:first-child").children("div .divProfDansLi").text();
                                updateUlQuestion(cours, idUsagerCourant, "selonQuiz", idQuiz,typeQuiz);
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
            if(resultat.trim() != "") {
                swal("Erreur !", resultat, "error");
            }
            else {
                swal("Félicitation !", "Votre quiz à été ajouté", "success");
                fermerDivDynamique();
                var idCours = $("#DDL_Cours option:selected").attr("value");
                updateUlQuiz(idCours, idUsagerProprietaire);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
        }
    });
}

function modifierQuiz(idQuiz, idUsagerProprietaire) {
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
        data: {"idQuiz":idQuiz, "titreQuiz":titreQuiz, "ordreEstAleatoire":ordreEstAleatoire, "estDisponible":estDisponible, "jsonCours":jsonCours, "idProprietaire":idUsagerProprietaire},
        dataType: "text",
        success: function(resultat){
            if(resultat.trim() != "") {
                swal("Erreur !", resultat, "error");
            }
            else {
                swal("Félicitation !", "Votre quiz à été modifié", "success");
                fermerDivDynamique();
                var idCours = $("#DDL_Cours option:selected").attr("value");
                updateUlQuiz(idCours, idUsagerProprietaire);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal("Erreur", jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown, "error"); // À mettre un message pour l'usager disant que l'ajout ne s'est pas effectué correctement.
        }
    });
}

function supprimerQuiz(idQuiz, idUsagerProprietaire) {
    swal({   title: "Êtes-vous sur?",
        text: "Cette action va supprimer ce quiz ainsi que toutes ces références. Êtes-vous sur de vouloir continuer?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Supprimer ce quiz",
        closeOnConfirm:false
    }, function(aAccepter){
        if(aAccepter) {
            $.ajax({
                type:"POST",
                url:'Controleur/AJAX_SupprimerQuiz.php',
                async : false,
                data: {"idQuiz":idQuiz},
                dataType: "text",
                success: function(resultat){
                    if(resultat.trim() != "") {
                        swal("Erreur !", resultat, "error");
                    }
                    else {
                        $(".dFondOmbrage").detach();
                        if($("#QuizDropZone").children("li").length == 1 && $("#QuizDropZone").children("li").attr("id") == idQuiz) {
                            $("#QuizDropZone").children("li").remove();
                        }
                        else {
                            var cours = $("#DDL_Cours option:selected").attr("value");
                            updateUlQuiz(cours, idUsagerProprietaire);
                        }
                        swal("Félicitation !", "Votre quiz à été supprimée", "success");
                    }
                }
            });
        }

    });
}
