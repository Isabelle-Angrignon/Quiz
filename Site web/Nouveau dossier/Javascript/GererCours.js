///////////////////////////////////////////////////////////////////////////
//
//  GererCours.js
//  Fait par : Simon Bouchard
//  Fait le : 2014-10-13
//  Contient toutes les fonctions spécifiques a gerer Cours
//
///////////////////////////////////////////////////////////////////////////

// remplirUIModifGroupeAjax
// fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Liste tout les élèves d'un cours et les insère dans le UI UIModifGroupe de la page gérer cours
// Intrant : L'id du cours
// Extrant : Aucun
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
//remplirUIEtudiantCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Lister tout le étudiants qui ne sont pas dans le cours spécifier comme intrant et les liste dans le
// UiEtudiants de la page gérer cours
// Intrant : L'id du cours
// Extrant : Aucun
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

//ListerEtudiantAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Liste tout les étudiants et le ajoute dans le UIEtudiants de la page gérer cours
// Intrant : Aucun
// Extrant : aucun
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

// inscrireEtudiantCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// permet d'inscrire un étudiant a un cours , si l'étudiant n'existe pas alors il sera créer
// Intrant : id de l'eleve , le nom de l'étudiant , le prénom de l'étudiant ainsi de l'id du cours
// ou il doit être inscrit
// extrant : Aucun
function inscrireEtudiantCoursAjax(idEleve,nomEleve,prenomEleve,Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/AjouterEtudiantCours.php",
        data: {"idCours" :Cours, "idE":idEleve,"nom" : nomEleve,"prenom" : prenomEleve },
        dataType: "html",
        success: function(resultat) {
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

// desinscrireEtudiantCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Permet de désinscrire un étudiant d'un cours spécifié en intrant
// Intrant : id de l'étudiant a inscrire , id du cours dans lequel l'étudiant doit être inscrit
// Extrant : Aucun
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

// creerEtudiantCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Permet de créer un étudiant dans la base de données
// intrant : id de l'étudiant , nom de l'étudiant , prénom de l'étudiant
// Extrant : réussite ou échec de l'opération
function creerEtudiantCoursAjax(idEleve,nom,prenom) {
    $.ajax({
        type: 'POST',
        url: "Controleur/AjouterUsager.php",
        data: {"idUsager" :idEleve, "nom" :nom, "prenom" :prenom},
        dataType: "text",
        success: function(resultat){
            if(resultat == 1) {
            swal({title:"Réussie" ,type:"success", text:"L'usager a été créé"});
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

// ajouterCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Crée un nouveau cours
// Intrant : le nom du cours , le code du cours
// Extrant : Aucun
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

// ListerCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Liste tout les cours dans le programme et les insère dans la liste UICours
// Intrant : Aucun
// Extrant : Aucun
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

// desinscrireToutEtudiantCoursAjax
// Fait par : Simon Bouchard
// Commenter le : 17/11/2014
// Méthode qui permet de désinscrire tout les étudiants d'un cours
// Intrant : L'id du cours duquel on veut désinscrire les étudiants
// Exrant : aucun
function desinscrireToutEtudiantCoursAjax(Cours) {
    $.ajax({
        type: 'POST',
        url: "Controleur/EnleverToutEtudiantCours.php",
        data: {"idCours" :Cours},
        dataType: "html",
        success: function(resultat) {
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}
