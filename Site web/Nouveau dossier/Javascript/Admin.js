///////////////////////////////////////////////////////////////////////////////////////
//
//  Admin.js
//  Fait par : Simon Bouchard<
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichier qui contient les différents appel ajax de la page admin ainsi que les fonctions
//  javascrpit nécessaire au bon fonctionnement de la page
//
///////////////////////////////////////////////////////////////////////////////////////

// CreerDeploiement
// Fait par : Simon Bouchard
// Commenter le : 12/11/2014
// Cette fonction insère le contenu d'un fichier a l'intérieur de la page admin
// Intrant : path = le path du fichier dont le contenu doit être insérer dans la page admin
function CreerDeploiement(path){
    $('#deploiement').remove();
    var zeDiv = document.createElement('div');
    zeDiv.setAttribute('id','deploiement');
    zeDiv.setAttribute('class','Liste');
    document.getElementById('leConteneur').appendChild(zeDiv);
    insererHTMLfromPHP('deploiement',path);

}



// Supprimer un Compte
// Fait par : Simon Bouchard
// Fait le : 12/11/2014
// Fait un appel ajax afin de supprimer un compte
// Fichier appeler : SupprimerUnCompte.php
// Réaction : Affiche un swal qui indique l'échec ou la réussite de l'opération
// Intrant : Le numéro de DA du compte a supprimer
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
                swal({   title: "Opération réussie!",   text: "Le compte a bel et bien été supprimer",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
// nommerAdminAjax
// Fait par : Simon Bouchard
// Fait le : 12/11/2014
// Fait un appel ajax afin de nommer un nouvel admin
// Fichier appelé : nommerAdmin.php
// Réaction : Affiche un swal qui indique la réussite ou l'échec de l'opération
// Intrant  : Le numéro de DA du professeur que l'on doit mettre administrateur
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
                swal({   title: "Opération réussie!",   text: "Le professeur a été augmenté au rang d'admin",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
// ListerCoursSelectAjax
// Fait par : Simon Bouchard
// Fait le : 12/11/2014
// Appel ajax qui liste les cours
// Fichier appelé : ListerCours.php
// Réaction : Créer la liste déroulante du déploiement de modifier Cours
// Intrant : Aucun
function ListerCoursSelectAjax() {
    $.ajax({
        type: 'POST',
        url: "Controleur/ListerCours.php",
        dataType: "json",
        async:false,
        success: function(resultat) {
            for(var i = 0; i < resultat.length; ++i) {
                ajouterOption_ToSelect('DDL_Cours',resultat[i].idCours,resultat[i].nomCours,resultat[i].codeCours);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
// ModifierCoursAjax
// Fait par : Simon Bouchard
// Fait le : 12/11/2014
// Appel ajax qui modifie des cours
// Fichier appelé : modifierCours.php
// Réaction : Affiche un swal qui indique la réussite ou l'échec de l'opération
// Intant : idCours = id du cours a modifier , nom = nouveau nom du cours , codeCours = nouveau code du cours
function ModifierCoursAjax(idCours,nomCours,codeCours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/modifierCours.php",
        data: {"idCours" :idCours,"nomCours":nomCours,"codeCours":codeCours},
        dataType: "text",
        async:false,
        success: function(resultat) {
            swal({title :"operation réussi", text:"Le cours a été modifier",type:"success"});
            CreerDeploiement('Vue/dynamique-ModifierCours.php');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
