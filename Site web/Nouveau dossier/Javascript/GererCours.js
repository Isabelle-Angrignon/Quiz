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
            var idUsager;
            var nom;
            var prenom;
            for(var i = 0; i < resultat.length; ++i) {
                idUsager = resultat[i].idUsager;
                nom = resultat[i].nom;
                prenom = resultat[i].prenom;

                ajouterLi_ToUl_V2("UlModifGroupe",nom + " " + prenom, idUsager, true);
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
            var idUsager;
            var nom;
            var prenom;
            for(var i = 0; i < resultat.length; ++i) {
                idUsager = resultat[i].idUsager;
                nom = resultat[i].nom;
                prenom = resultat[i].prenom;

                ajouterLi_ToUl_V2("UlEtudiants",nom + " " + prenom, idUsager, true);
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
            var idUsager;
            var nom;
            var prenom;
            for(var i = 0; i < resultat.length; ++i) {
                idUsager = resultat[i].idUsager;
                nom = resultat[i].nom;
                prenom = resultat[i].prenom;

                ajouterLi_ToUl_V2("UlEtudiants",nom + " " + prenom, idUsager, true);
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
        success: function(resultat) {},
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
        success: function(resultat) {alert(resultat);},
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
            var idCours;
            var codeCours;
            var nomCours;
            for(var i = 0; i < resultat.length; ++i) {
                idCours = resultat[i].idCours;
                codeCours = resultat[i].codeCours;
                nomCours = resultat[i].nomCours;

                ajouterLi_ToUl_V2("UlCours",codeCours + " " + nomCours, idCours, true);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}