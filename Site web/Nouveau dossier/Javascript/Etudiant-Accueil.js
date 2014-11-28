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
        swal({ title: "Désolé",   text: "Ce type de quiz n'est pas géré.",   type: "warning",   confirmButtonText: "Ok" });
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
        creeFrameDynamique("divDynamique", "Vue/dynamique-RepondreQuestion.php", true);
    }
    else  {
        swal({ title: "Désolé",   text: "Il n'y a aucune question dans ce quiz.",   type: "warning",   confirmButtonText: "Ok" });
    }
}

// Par: Isabelle Angrignon
// Nom: getOrdreQuestionEstAleatoire
// But:  Récupère la valeur de la variable de session qui dit si l'ordre des questions est aléatoire ou non)
//       pour un quiz passé en paramètre
// Intrants: idQuiz: unsigned int(10), clé primaire du quiz de la table Quiz
// Extrants: ordre: int 0|1 (1 = aleatoire)
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
            swal({ title: "Désolé",   text: "Il n'y a aucune question aléatoire définie pour ce cours.",   type: "warning",   confirmButtonText: "Ok" });
        }
    }
    else  {
        swal({ title: "Oups...",   text: "Vous devez sélectionner un cours spécifique pour générer un quiz aléatoire",   type: "error",   confirmButtonText: "Ok" });
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
    var index = $("#DDL_Cours option:selected").index();

    // Pour une raison création via jQuery-ui qui insert un script entre chaque li,
    // l'index est par bond de 2: 1, 3, 5, ,7...
    // On doit donc faire le calcul suivant pour récupérer l'index de position dans la
    // variable de session"listeCours".  On enlève 1 à la fin pour éliminer l'item "tous les cours" qui n'est pas
    // dans la variable de session
    var posCoursDansListe = (index-1)/2 -1;
    var coursEstChoisi = 0;

    // Sur click quiz aléatoire, reécupere le id du cours et le met dans session
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/SetIdCoursSession.php',
        data:{'selectCours':idCours, 'posCoursDansListe':posCoursDansListe},
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
//      2 - Afficher le "sweet alert" si on u ou pas répondu du tout.
//      3 - Si répondu, met en couleur les réponses selon bon ou mauvais et change le bouton pour "suivant"
//          on appelle ensuite "continuerQuiz" qui s'occupe de la suite des choses.
//      3 - Met à jour le score affiché.
// Intrants:  résultat int 1|0
//            lien (hypertext) string:  vers les notes de cours reliées à la question répondue affiché en cas de
//            mauvaise réponse en mode aléatoire seulement
//            typeQuiz: enum parmi "ALEATOIRE", "FORMATIF", ou autre éventuellement
// Extrants: aucun
function traiterResultatReponse(resultat, lien, typeQuiz){

    //Gestion des cas de réponses possibles: 1, 0, X; 1 = bonne réponse, 0 = erreur, x= erreur de correction
    if(resultat == 1) {

        updateScoreAffiche(resultat);
        //recup idBonneReponse
        getVarSessionAjax("idBonneReponse").success(function(id){
            //reformater li
            var selector = "#UlChoixReponse > #"+id.trim();
            $(selector).css("background", "rgba(40,191,40,0.8)");//Vert
        });
        $( "#UlChoixReponse" ).selectable( "disable" );
        $("#btnValider").hide();
        $("#btnSuivant").show();
        $("#btnSuivant").click(function(){
            continuerQuiz();
            $( "#UlChoixReponse" ).selectable( "enable" );
        });
    }
    else if(resultat == 0) {
                //On affiche le lien hypertext que si: il y en a un, la réponse est mauvaise et on est en type de quiz aléatoire
        if(lien == null || lien == "" || typeQuiz != "ALEATOIRE"){
            //recup idBonneReponse
            getVarSessionAjax("idBonneReponse").success(function(id){
                //reformater li
                var selector = "#UlChoixReponse > #"+id.trim();
                $(selector).css("background", "rgba(40,191,40,0.8)");//Vert
                $("#UlChoixReponse .ui-selected").css("background", "rgba(207,59,29,0.8)");//Rouge
            });
            $( "#UlChoixReponse" ).selectable( "disable" );
            $("#btnValider").hide();
            $("#btnSuivant").show();
            $("#btnSuivant").click(function(){
                continuerQuiz();
                $( "#UlChoixReponse" ).selectable( "enable" );
            });
        }
        else{
            swalMauvaiseReponseLien(true,lien);
        }
        updateScoreAffiche(resultat);
    }
    else if(resultat == 'X') {
        swalErreurDeCorrection();
    }
    else {
     //   swalQuestionNonRepondue();
    }
}

// Différents messages "SweetAlert" selon la réponse et la situation de quiz.
// Dans le cas ou il y a eu réponse,on appelle la méthode continuerQuiz.
//Pouyr bonne ou mauvaise réponse, on prend un bool pour dire si on ferme le sweetAlert ou non après affichage selon
// qu'on aura une autre alerte a afficher.
function swalBonneReponse(close){
    swal({   title: "Bravo!",   text: "Bonne réponse!",   type: "success",
        confirmButtonText: "Ok", closeOnConfirm:close},function() { continuerQuiz();});
}
function swalMauvaiseReponse(close){
    swal({   title: "Oups!",   text: "Mauvaise réponse!",   type: "error",
        confirmButtonText: "Ok", closeOnConfirm:close},function() { continuerQuiz();});
}
function swalMauvaiseReponseLien(close, lien){
    swal({  title: "Mauvaise réponse!",
            text: "Votre gentil prof vous suggère de réviser au lien ci-dessous",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#FFA64F",
            confirmButtonText: "Suivant",
            cancelButtonText: "Réviser",
            closeOnConfirm: close,
            closeOnCancel: true },
        function(isConfirm) {
            if (isConfirm) {
                getVarSessionAjax("idBonneReponse").success(function(id){
                    //reformater li
                    var selector = "#UlChoixReponse > #"+id.trim();
                    $(selector).css("background", "rgba(40,191,40,0.8)");//Vert
                    $("#UlChoixReponse .ui-selected").css("background", "rgba(207,59,29,0.8)");//Rouge
                });
                $( "#UlChoixReponse" ).selectable( "disable" );
                $("#btnValider").hide();
                $("#btnSuivant").show();
                $("#btnSuivant").click(function(){
                    continuerQuiz();//todo resurchaerge bouton suivant pour continuer
                    $( "#UlChoixReponse" ).selectable( "enable" );
                });
            }
            else {
                window.open(lien);
            }
        });
}
function swalErreurDeCorrection(){
    swal({   title: "Heu...",   text: " Une erreur s'est produite au moment de la validation.  Les stats ne sont pas compilées ",
        type: "warning",   confirmButtonText: "Ok" });
}
function swalQuestionNonRepondue(){
    swal({   title: "Oups!",   text: "Répondez d'abord à la question!",   type: "error",
        confirmButtonText: "Ok" });
}

// Par: Isabelle Angrignon
// Nom: gererQuestionRepondue
// But:  Envoi la réponse cliquée par ajax au test de validation de la réponse et retourne le résultat à la fonction
//      traiterResultatReponse
// Intrants: un lien hypertexte lié à la question
//           le type de quiz parmi: "ALEATOIRE", "FORMATIF" ou autre éventuellement
// Extrants: auncun
function gererQuestionRepondue(lien, typeQuiz) {

    //Récupérer le id de la réponse cliquée
    var idReponse;
    $("#UlChoixReponse .ui-selected").each(function() {
        idReponse = $(this).attr("id");
    });
    if(idReponse == null){
        swalQuestionNonRepondue();
    }
    else{
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
}

// Par: Isabelle Angrignon
// Nom: estDerniereQuestion
// But:  Vérifie la valeur de la variable de session qui dit combien il reste de questions au quiz et
//       retourne 1 si on est rendu à la dernière question
// Intrants: aucun
// Extrants: estDerniere int 0|1
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

// Par: Isabelle Angrignon
// Nom: updateScoreAffiche
// But:  Par ajax, envoie le résultat obtenu à la méthode php qui gère les variables de session appropriées et génère
//      le message de score à afficher dans l'entête de quiz.
// Intrants: le résultat int 0|1
// Extrants: aucun
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

// Par: Isabelle Angrignon
// Nom: chargerNouvelleQuestion
// But:  1- par ajax, on charge les éléments de la prochaine question via les variable de session
//       2- on réinsert les nouvelles infos de la nouvelle question dans le div dynamique
// Intrants: aucun
// Extrants: aucun
function chargerNouvelleQuestion(){

    //viderHTMLfromElement('QuestionAleatoire');
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

// Par: Isabelle Angrignon
// Nom: continuerQuiz
// But: Gestion de la suite du quiz après une réponse.
// Intrants: aucun
// Extrants: aucun
function continuerQuiz() {
    if (quizTermine() == 1) {
        gererFinQuiz();
    }
    else {
        chargerNouvelleQuestion();//dans la session et la page
    }
}

// Par: Isabelle Angrignon
// Nom: quizTermine
// But: par ajax, vérifie si le quiz est terminé et retourne 1 ou 0
// Intrants: aucun
// Extrants: termine int 1|0
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

// Par: Isabelle Angrignon
// Nom: gererFinQuiz
// But: par ajax, fait la gestion des variables de session reliées au quiz et génère l'affichage du message de score total
// Intrants: aucun
// Extrants: aucun
function gererFinQuiz(){
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/gererFinQuiz.php",
        async : !1,
        success: function(msg) {
            $('#dFondOmbrage').remove();
            swal({title: "Quiz terminé!", text: msg, type: "success", confirmButtonText: "Ok"});
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
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