// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


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