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


function genererQuestionsAleatoires()
{
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
/*var zeSingleton = (function(){
    this.OstieDeBooleen = 0;
    this.VireATrue = function(){this.OstieDeBooleen = 1;}
    this.obtenirBooleen = function(){return this.OstieDeBooleen;}
});*/

function gererQuestionRepondue() {

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
            //serie de if pour débuggage a remplacer par des sweetAlert.
            if(resultat == 1)
            {
                swal({   title: "Bravo!",   text: "Bonne réponse!",   type: "success",   confirmButtonText: "Dac!" });
            }
            else if(resultat == 0)
            {
                swal({   title: "Oups!",   text: "Mauvaise réponse!",   type: "error",   confirmButtonText: "Dac!" });
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
            //retour de validation si question répondue...
            if (resultat == 1 || resultat == 0)
            {
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
                insererHTMLfromPHP("QuestionAleatoire", "Vue/dynamique-RepondreQuestion.php");

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });

}

function quizTermine()
{
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

function afficherScoreFinal()
{
    $.ajax({
        type:"POST",
        url:"Controleur/FonctionQuizEtudiant/afficherScoreFinal.php",
        async : !1,
        success: function(msg) {
            alert(msg);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert( textStatus + " /// " + errorThrown +" /// "+ jqXHR.responseText);
        }
    });
}


