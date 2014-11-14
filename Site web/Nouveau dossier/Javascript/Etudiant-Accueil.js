// Etudiant-Accueil.js
// Par Isabelle Angrignon
// Date : 14/10/2014
// Description : Contient tout le code Javascript spécifique à la page Etudiant-Accueil.php

////////// Modele commentaires //////////////////
// Par: Isabelle Angrignon
// Nom:
// But:
// Intrants:
// Extrants:
//////////////////////////////////////////////////

// Par: Isabelle Angrignon
// Nom: addClickEventToQuizFormatif
// But: Ajoute un gestionnaire d'événement qui permet d'ouvrir un quiz formatif à partir de l'identifiant unique d'un quiz (idQuiz)
// Intrants: aucun
// Extrants: aucun
function addClickEventToQuizFormatif(){
    $("#UlQuizFormatif li").off("click");
    $("#UlQuizFormatif li").click( function() {
        //Récupérer idQuiz:
        var idQuiz = $(this).attr('id');
        var titreQuiz = $(this).attr('placeholder');
        var idProf = $(this).children("div").attr('placeholder');
        var nomProf = $(this).children("div").text();
        setInfoQuizSession(idQuiz, titreQuiz, idProf, nomProf );
        //appeler la fonction php qui génere une liste de questions pour un idQuiz spécifique...
        ouvrirUnQuiz("FORMATIF", idQuiz );
    });
}

// Par: Isabelle Angrignon
// Nom: ouvrirUnQuiz
// But: Permet l'appel de la méthode ouvrirQuizFormatif ouvrirQuizAleatoire selon son type.
// Intrants: type de quiz: selon enum: ALEATOIRE, FORMATIF ou SOMMATIF
//           idQuiz: unsigned int(10), clé primaire du quiz de la table Quiz
// Extrants: aucun sauf si erreur
function ouvrirUnQuiz(typeQuiz, idQuiz){
    if (typeQuiz == "ALEATOIRE"){
        ouvrirUnQuizAleatoire();
    }
    else if (typeQuiz == "FORMATIF") {
        ouvrirUnQuizFormatif(idQuiz);
    }
    else{
        swal({ title: "Désolé",   text: "Ce type de quiz n'est pas géré.",   type: "warning",   confirmButtonText: "Dac!" });
    }
}

// Par: Isabelle Angrignon
// Nom: ouvrirUnQuizFormatif
// But:  Permet la préparation de la liste de questions (aléatoire ou non) du quiz formatif passé en paramètre
//       et crée la fenêtre d'affichage de question à répondre s'il y a des questions à répondre.
// Intrants: idQuiz: unsigned int(10), clé primaire du quiz de la table Quiz
// Extrants: aucun sauf si aucune liste de généré, on affiche une alerte.
function ouvrirUnQuizFormatif(idQuiz){
    var ordreQuestEstAleatoire = getOrdreQuestionEstAleatoire(idQuiz);
    if (genererListeQuestions("FORMATIF", idQuiz, ordreQuestEstAleatoire) == 1) {
        creeFrameDynamique("divDynamique", "Vue/dynamique-RepondreQuestion.php");
    }
    else  {
        swal({ title: "Désolé",   text: "Il n'y a aucune question dans ce quiz.",   type: "warning",   confirmButtonText: "Dac!" });
    }
}
//todo commentaires
function getOrdreQuestionEstAleatoire(idQuiz){
    var ordre = 0;
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/getOrdreQuestionsEstAleatoire.php',
        data:{'idQuiz':idQuiz},
        dataType:"text",
        async : !1,
        success: function(resultat){
            ordre = resultat;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return ordre;
}


// Par: Isabelle Angrignon
// Nom: ouvrirUnQuizAleatoire
// But:  Permet la préparation de la liste de questions aléatoires pour un cours spécifique et crée la fenêtre
//       d'affichage de question à répondre s'il y a des questions à répondre.
//      On vérifie d'abors si un cours est sélectionné dans le menu déroulant, sinon on affiche une alerte
// Intrants: aucun
// Extrants: aucun sauf si aucune liste de généré ou si aucun cours n'est sélectionné, alors on affiche une alerte.
function ouvrirUnQuizAleatoire(){
    if (SetIdCoursSession()==1) {
        if (genererListeQuestions("ALEATOIRE", 0) == 1) {
            creeFrameDynamique("divDynamique", "Vue/dynamique-RepondreQuestion.php");
        }
        else {
            swal({ title: "Désolé",   text: "Il n'y a aucune question aléatoire définie pour ce cours.",   type: "warning",   confirmButtonText: "Dac!" });
        }
    }
    else  {
        swal({ title: "Oups...",   text: "Vous devez sélectionner un cours spécifique pour générer un quiz aléatoire",   type: "error",   confirmButtonText: "Dac!" });
    }
}

// Par: Isabelle Angrignon
// Nom: SetIdCoursSession
// But: Récupère le idCours du cours sélectionné dans le menu déroulant et fait appel à la page php appelée par Ajax
//      pour mettre la valeur dans la variable de session pour usage futur.
// Intrants: aucun
// Extrants: coursEstChoisi: int 0|1
function SetIdCoursSession(){
    var idCours = $("#DDL_Cours option:selected").attr("value");
    var coursEstChoisi = 0;

    // Sur click quiz aléatoire, reécupere le id du cours et le met dans session
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/SetIdCoursSession.php',
        data:{'selectCours':idCours},
        dataType:"text",
        async : !1,
        success: function(msg){
            coursEstChoisi = msg;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return coursEstChoisi;
}

// Par: Isabelle Angrignon
// Nom: setIdQuizSession
// But: Récupère le idQuiz du quiz FORMATIF ou SOMMATIF sélectionné dans la liste de quiz et fait appel à la page php
//      appelée par Ajax pour mettre la valeur dans la variable de session pour usage futur.
// Intrants: idQuiz: unsigned int(10)
// Extrants: aucun
//Met le idQuiz dans la variable de session et réinitialise les variables de sessions relatives à un quiz.
function setInfoQuizSession(idQuiz,titreQuiz,  idProf, nomProf){
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/setInfoQuizSession.php',
        data:{'selectQuiz':idQuiz,'titreQuiz': titreQuiz, 'idProf': idProf, 'nomProf':nomProf},
        dataType:"text",
        async : !1,
        success: function(msg){     },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}

// Par: Isabelle Angrignon
// Nom: listerQuizFormatifs
// But: Appel par Ajax à la page php qui génère la liste des quiz formatifs incluant le nom du prof en petits caracteres.
//      de session).  Recoit une liste de format JSON que l'on utilise pour mettre dans les éléments "li" de la liste de quiz.
// Intrants: aucun
// Extrants: aucun
function listerQuizFormatifs(){
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/ListerQuizFormatifs.php',
        async : !1,
        dataType: "json",
        success: function(resultat){
            if(resultat != null){
                for (var i = 0; i < resultat.length; ++i){
                    ajouterLi_ToUl_Selectable_Div("UlQuizFormatif", resultat[i].titreQuiz , resultat[i].idQuiz,
                        true, resultat[i].prenom + " " + resultat[i].nom, "divDansLi", resultat[i].idUsager_proprietaire);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}


// Par: Isabelle Angrignon
// Nom: genererListeQuestions
// But: Appelle la méthode qui génère la liste de questions selon le type de quiz choisi
// Intrants: type de quiz: selon enum: ALEATOIRE, FORMATIF ou SOMMATIF
//           idQuiz: unsigned int(10), clé primaire du quiz de la table Quiz
//           ordreQuestionsEstAleatoire: int, 1|0
// Extrants: quizEstCree: int 0|1
function genererListeQuestions(typeQuiz, idQuiz, ordreQuestionsEstAleatoire ){
    //Détermine la valeur par défaut de l'ordre des questions à aléatoire si pas passé en paramètre
    ordreQuestionsEstAleatoire = (typeof ordreQuestionsEstAleatoire === 'undefined') ? 1 : ordreQuestionsEstAleatoire;
    if (typeQuiz == "FORMATIF"){
        return listerQuestionsFormatif(idQuiz, ordreQuestionsEstAleatoire );
    }
    else if (typeQuiz == "ALEATOIRE"){
        return genererQuestionsAleatoires();
    }
    else {
        return 0;
    }
}

// Par: Isabelle Angrignon
// Nom: listerQuestionsFormatif
// But: Génère la liste de questions du quiz choisi passé en paramètres
// Intrants: idQuiz: unsigned int(10), clé primaire du quiz de la table Quiz
//           ordreQuestionsEstAleatoire: int, 1|0
// Extrants: quizEstCree: int 0|1
function listerQuestionsFormatif(idQuiz, ordreQuestionsEstAleatoire){
    var quizEstCree = 0;
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/listerQuestionsFormatif.php",
        async : !1,
        data: {"idQuiz" : idQuiz , "ordreQuestionsEstAleatoire" : ordreQuestionsEstAleatoire },
        success: function(msg) {
            quizEstCree = msg;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return quizEstCree;
}

// Par: Isabelle Angrignon
// Nom: genererQuestionsAleatoires
// But: Génère la liste de questions aléatoires d'un cours choisi (selon la variable de session
// Intrants: aucun
// Extrants: quizEstCree: int 0|1
function genererQuestionsAleatoires(){
    var quizEstCree = 0;
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/GenererQuestionsAleatoires.php",
        async : !1,
        success: function(msg) {
            quizEstCree = msg;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return quizEstCree;
}

// Par: Isabelle Angrignon
// Nom: traiterResultatReponse
// But: 1 - Vérifie si on est rendu à la dernière question: si oui, on s'assure que le "sweet alert" de quiz terminé va
//          s'afficher après le "sweet alert" du résultats de la question qui vient d'être répondue.
//      2 - Afficher le "sweet alert" approprié selon qu'on a bien répondu, mal répondu ou pas répondu du tout.
//          Si répondu, on appelle "continuerQuiz" qui s'occupe de la suite des choses.
//      3 - Met à jour le score affiché.
// Intrants:  résultat int 1|0
// Extrants: aucun
function traiterResultatReponse(resultat, lien, typeQuiz){
    var close  = true; //Variable pour dire au sweetalert de réponse de se fermer après qu'on ait cliqué ok.
    // si c'est la dernière question, alors on va afficher un autre sweetalert pour le score final donc,
    //la variable close doit être à false.

    //valide que la dernière question a été chargée dans la page
    if (estDerniereQuestion() == 1){ close =false; }

    //récupère le lien de référence aux notes de cours

    if(resultat == 1) {
        swal({   title: "Bravo!",   text: "Bonne réponse!",   type: "success",
            confirmButtonText: "Dac!", closeOnConfirm:close},function() { continuerQuiz();});
    }
    else if(resultat == 0) {

        // ajouter un ajax pour récupérer le lien hypertext de la question si il y en a une.
        if(lien == null || lien == "" || typeQuiz != "ALEATOIRE"){
            swal({   title: "Oups!",   text: "Mauvaise réponse!",   type: "error",
                confirmButtonText: "Dac!", closeOnConfirm:close},function() { continuerQuiz();});
        }
        else{
            swal({  title: "Oups!",
                    text: "Mauvaise réponse!  Voulez-vous continuer ou réviser?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Continuer quand même...",
                    cancelButtonText: "Aller réviser!",
                    closeOnConfirm: close,
                    closeOnCancel: true },
                    function(isConfirm) {
                        if (isConfirm) {
                            continuerQuiz();
                        }
                        else {
                           /*todo  redirect */
                            window.open(lien);
                        }
                    });
        }
    }
    else if(resultat == 'X') {
        swal({   title: "Oh la la!",   text: " Une erreur s'est produite au moment de la validation. ",   type: "warning",   confirmButtonText: "Dac!" });
    }
    else {
        swal({   title: "Oups!",   text: "Répondez d'abord à la question!",   type: "error",
            confirmButtonText: "Dac!" });
    }
    //retour de validation si question répondue...
    if (resultat == 1 || resultat == 0) {
       // estRepondu = 1;
        updateScoreAffiche(resultat);
    }
}
//todo commentaires
function estDerniereQuestion(){
    var lien = "";
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/estDerniereQuestion.php",
        async : !1,
        success: function(res) {
            estDerniere = res;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return lien;
}

//todo continuer commentaires
function gererQuestionRepondue(continuerQuiz, lien, typeQuiz) {

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
        async : !1,
        datatype: "text",
        success: function(resultat) {
            traiterResultatReponse(resultat, lien, typeQuiz);
        },
         error: function(jqXHR, textStatus, errorThrown) {
             alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}

function estDerniereQuestion(){
    var estDerniere = 0;
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/estDerniereQuestion.php",
        async : !1,
        success: function(res) {
            estDerniere = res;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return estDerniere;
}

function updateScoreAffiche(resultat){
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/updateScoreAffiche.php",
        data: {"resultat": resultat},
        datatype: "text",
        async : !1,
        success: function(score) {
            $('#labelScore').text(score);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}

function chargerNouvelleQuestion(){

   // viderHTMLfromElement('QuestionAleatoire');
    viderHTMLfromElement('QuestionAleatoire');
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/chargerNouvelleQuestion.php",
        async : !1,
        success: function(msg) {
                //recharger le div dynamique
                insererHTMLfromPHP("divDynamique", "Vue/dynamique-RepondreQuestion.php");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}

function continuerQuiz() {
    if (quizTermine() == 1) {
        afficherScoreFinal();
    }
    else {
        chargerNouvelleQuestion();//dans la session
    }
}

function quizTermine(){
    var termine = 0;
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/verifierSiQuizTermine.php",
        async : !1,
        success: function(msg) {
            termine = msg;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return termine;
}

function afficherScoreFinal(){
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/afficherScoreFinal.php",
        async : !1,
        success: function(msg) {
            $('#dFondOmbrage').remove();
            swal({title: "Quiz terminé!", text: msg, type: "success", confirmButtonText: "Dac!"});
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}


