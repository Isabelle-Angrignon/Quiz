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
                swal({   title: "Erreur!",   text: "Le numero de DA est invalide ou le mot de passe est déjà le mot de passe par défaut",   type: "error"});
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