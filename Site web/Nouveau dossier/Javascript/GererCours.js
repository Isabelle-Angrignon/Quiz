//GererCours.js
// Fait par : Simon Bouchard
// Fait le : 2014-10-13
// Contient toutes les fonctions spécifiques a gerer Cours

function remplirUIModifGroupeAjax(Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/ListerEleveDansCours.php",
        data: {"idCours" :Cours },
        dataType: "json",
        success: function(resultat) {
            for(var i = 0; i < resultat.length; ++i) {
                ajouterLi_AvecDiv("UlModifGroupe",resultat[i].nom + " " + resultat[i].prenom,
                    resultat[i].idUsager, true,resultat[i].idUsager,"divDansLi", "allo");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function remplirUIEtudiantCoursAjax(Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/ListerElevePasDansCours.php",
        data: {"idCours" :Cours },
        dataType: "json",
        success: function(resultat) {
            for(var i = 0; i < resultat.length; ++i) {
              ajouterLi_AvecDiv("UlEtudiants",resultat[i].nom + " " + resultat[i].prenom,
                    resultat[i].idUsager, true,resultat[i].idUsager,"divDansLi", "");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function ListerEtudiantAjax() {
    $.ajax({
        type: 'GET',
        url: "Controleur/ListerEleve.php",
        dataType: "json",
        success: function(resultat) {
            for(var i = 0; i < resultat.length; ++i) {
                ajouterLi_AvecDiv("UlEtudiants",resultat[i].nom + " " +
                resultat[i].prenom, resultat[i].idUsager, true,resultat[i].idUsager,"divDansLi", "");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function inscrireEtudiantCoursAjax(idEleve,nomEleve,prenomEleve,Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/AjouterEtudiantCours.php",
        data: {"idCours" :Cours, "idE":idEleve,"nom" : nomEleve,"prenom" : prenomEleve },
        dataType: "html",
        success: function(resultat) {
           // alert(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function desinscrireEtudiantCoursAjax(idEleve,Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/EnleverEtudiantCours.php",
        data: {"idCours" :Cours, "idE":idEleve},
        dataType: "html",
        success: function(resultat) {
            // alert(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function creerEtudiantCoursAjax(idEleve,nom,prenom) {
    $.ajax({
        type: 'POST',
        url: "Controleur/AjouterUsager.php",
        data: {"idUsager" :idEleve, "nom" :nom, "prenom" :prenom},
        dataType: "text",
        success: function(resultat){
            if(resultat == 1) {
            swal({title:"Réussite" ,type:"success", text:"L'usager a été créer"});
                $("#TB_NumeroDA").val("");
                $("#TB_Nom").val("");
                $("#TB_Prenom").val("");
        }
        else if (resultat==0){
            swal({title:"Échec" ,type:"error", text:"Ce numero de DA existe déjà"});
        }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function ajouterCoursAjax(nom,code) {
    $.ajax({
        type: 'POST',
        url: "Controleur/AjouterCours.php",
        data: {"nom" :nom, "code" :code},
        dataType: "html",
        success: function(resultat) {},
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

function ListerCoursAjax() {
    $.ajax({
        type: 'POST',
        url: "Controleur/ListerCours.php",
        dataType: "json",
        success: function(resultat) {
            for(var i = 0; i < resultat.length; ++i) {
                ajouterLi_AvecDiv("UlCours",(resultat[i].nomCours).substr(0,25),
                    resultat[i].idCours, true,resultat[i].codeCours,"divDansLi");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
function desinscrireToutEtudiantCoursAjax(Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/EnleverToutEtudiantCours.php",
        data: {"idCours" :Cours},
        dataType: "html",
        success: function(resultat) {
            // alert(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}