/**
 * Created by Simon on 24/10/2014.
 */
function CreerDeploiement(path){
    $('#deploiement').remove();
    var zeDiv = document.createElement('div');
    zeDiv.setAttribute('id','deploiement');
    zeDiv.setAttribute('class','Liste');
    document.getElementById('leConteneur').appendChild(zeDiv);
    insererHTMLfromPHP('deploiement',path);

}


function reinitialiserMotDePasse(numeroDA) {
    $.ajax({
        type: 'POST',
        url: "Controleur/ReinitialiserMotDePasse.php",
        data: {"numeroDA" :numeroDA},
        dataType: "text",
        success: function(resultat) {
            if (resultat == 0) {
                swal({   title: "Erreur!",   text: "Le mot de passe est déjà le mot de passe par défaut",   type: "error"});
                $("#TB_DA").val("");
            }
            else if (resultat == 1)
            {
                swal({   title: "Opération réussite!",   text: "Reinitialisation de mot de passe réussi",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function supprimerUnCompte(numeroDA){
    $.ajax({
        type: 'POST',
        url: "Controleur/SupprimerUnCompte.php",
        data: {"numeroDA" :numeroDA},
        dataType: "text",
        success: function(resultat) {
            alert(resultat);
            if (resultat == 0) {
                swal({   title: "Erreur!",   text: "Une érreur est survenue",   type: "error"});
                $("#TB_DA").val("");
            }
            else if (resultat == 1)
            {
                swal({   title: "Opération réussite!",   text: "Le compte a bel et bien été supprimer",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
function nommerAdminAjax(numeroDA){
    $.ajax({
        type: 'POST',
        url: "Controleur/nommerAdmin.php",
        data: {"numeroDA" :numeroDA},
        dataType: "text",
        success: function(resultat) {
            alert(resultat);
            if (resultat == 0) {
                swal({   title: "Erreur!",   text: "Une érreur est survenue",   type: "error"});
                $("#TB_DA").val("");
            }
            else if (resultat == 1)
            {
                swal({   title: "Opération réussite!",   text: "Le professeur a été augmenté au rang d'admin",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}