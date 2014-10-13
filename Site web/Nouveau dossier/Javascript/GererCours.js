//GererCours.js
// Fait par : Simon Bouchard
// Fait le : 2014-10-13
// Contient toutes les fonctions spécifiques a gerer Cours

function remplirUIModifGroupeAjax(Cours) {
    $.ajax({
        type: 'POST',
        url: "../Controleur/ListerEleveDansCours.php",
        data: '{idCours :"'+ Cours +'"}',
        dataType: "json",
        success: function(resultat) {
            alert(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}