// Etudiant-Accueil.js
// Par Isabelle Angrignon
// Date : 14/10/2014
// Description : Contient tout le code Javascript spécifique à la page Etudiant-Accueil.php

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

function listerQuizFormatifs(){
    $.ajax({
        type:"POST",
        url: 'Controleur/FonctionQuizEtudiant/ListerQuizFormatifs.php',
        async : !1,
        dataType: "json",
        success: function(resultat){
            if(resultat != null){
                for (var i = 0; i < resultat.length; ++i){
                    ajouterLi_ToUl_Selectable("UlQuizFormatif", resultat[i].titreQuiz , resultat[i].idQuiz, true);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}

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

function gererQuestionRepondue(continuerQuiz) {

    //Récupérer le id de la réponse cliquée
    var idReponse;
    estRepondu =0;
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
            var close  = true; //Variable pour dire au sweetalert de réponse de se fermer après qu'on ait cliqué ok.
            // si c'est la dernière question, alors on va afficher un autre sweetalert pour le score final donc,
            //la variable close doit être à false.

            //valide que la dernière question a été chargée dans la page
            if (estDerniereQuestion() == 1){ close =false; }

            if(resultat == 1) {
                swal({   title: "Bravo!",   text: "Bonne réponse!",   type: "success",   confirmButtonText: "Dac!", closeOnConfirm:close},function() { continuerQuiz();});
            }
            else if(resultat == 0) {
                swal({   title: "Oups!",   text: "Mauvaise réponse!",   type: "error",   confirmButtonText: "Dac!", closeOnConfirm:close},function() { continuerQuiz();});
                // ajouter un ajax pour récupérer le lien hypertext de la question si il y en a une.
            }
            else if(resultat == 'X') {
                swal({   title: "Oh la la!",   text: " Une erreur s'est produite au moment de la validation. ",   type: "warning",   confirmButtonText: "Dac!" });
            }
            else {
                swal({   title: "Oups!",   text: "Répondez d'abord à la question!",   type: "error",   confirmButtonText: "Dac!" });
            }
            //retour de validation si question répondue...
            if (resultat == 1 || resultat == 0) {
                estRepondu = 1;
                updateScoreAffiche(resultat);
                // Update stats bd
                // to do///////
            }
        },
         error: function(jqXHR, textStatus, errorThrown) {
             alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
    return estRepondu;
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


