﻿// Generique.js
// Par Mathieu Dumoulin
// Date : 15/09/2014
// Description : Contient tout le code Javascript générique de l'application QuizInfo


///// fonction anonyme???????
$(function() {
    // Ce bout de code sert à "resize" le menu selon le nombre d'enfant (de balise <a> ) qu'il contient
    $("nav").ready(function() {
        $("nav").each(function() {
            var nbElement = $(this).children("a").length;
            var format = 100/nbElement;
            $(this).children("a").each( function() {
                $(this).width(format + "%");
            });
        });

    });
});
// Nom : ajouterOption_ToSelect
// Par : Mathieu Dumoulin
// Date : 15/09/2014
// Intrant(s) : String idSelect, String element 
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Select et lui ajoute le texte à afficher ainsi que
// l'élément "unique" en tant qu'attribut value(passés en paramètre) à l'aide d'une balise option.
function ajouterOption_ToSelect(idSelect, element, texte,placeHolder) {
	var optionTag = document.createElement("option");
	optionTag.setAttribute("value", element);
    if(placeHolder != null){
        optionTag.setAttribute("placeholder",placeHolder);
    }
	// createTextNode permet de mettre du texte représentant notre balise (ce que l'usager voit comme texte)
	optionTag.appendChild(document.createTextNode(texte));
	document.getElementById(idSelect).appendChild(optionTag);
}


// Nom : ajouterLi_ToUl
// Par : Mathieu Dumoulin
// Date : 19/09/2014
// Intrant(s) : String idUl, String element, bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe pour le thême d'un sortable au Li si estThemeJqueryUI est à true
function ajouterLi_ToUl(idUl, element, estThemeJqueryUI) {
	// Initialisation du li
	var liTag = document.createElement("li");
	liTag.Value = element;
	if(estThemeJqueryUI) {
		liTag.setAttribute("class", "ui-state-default");
		// Initialisation du span contenu dans le li (nécéssaire pour les sortables)
		var spanTag = document.createElement("span");
	/*	spanTag .setAttribute("class", "ui-icon ui-icon-arrowthick-2-n-s");
		liTag.appendChild(spanTag);*/
	}
	liTag.appendChild(document.createTextNode(element));
	document.getElementById(idUl).appendChild(liTag);
}

// Nom : ajouterLi_ToUl_V2
// Par : Mathieu Dumoulin
// Date : 19/09/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe pour le thême d'un sortable au Li si estThemeJqueryUI est à true
function ajouterLi_ToUl_V2(idUl, element,idElement, estThemeJqueryUI) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.Value = element;
    liTag.setAttribute("id",idElement);
    if(estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default");
    }
    liTag.appendChild(document.createTextNode(element));
    document.getElementById(idUl).appendChild(liTag);
}

// Nom : ajouterLi_ToUl_Selectable
// Par : Mathieu Dumoulin, modifié par Isabelle Angrignon
// Date : 19/09/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe pour le thême d'un selectable au Li si estThemeJqueryUI est à true.
//               La différence de cette fonction comparée aux autres est quelle ajoute le terme selectable à la classe JQueryUI que le Li se fait attribuée.
function ajouterLi_ToUl_Selectable(idUl, element,idElement, estThemeJqueryUI) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.Value = element;
    liTag.setAttribute("id",idElement);
    if(estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default selectable");
    }
    liTag.appendChild(document.createTextNode(element));
    document.getElementById(idUl).appendChild(liTag);
}
// Nom : ajouterLi_ToUl_Selectable_Div
// Par : Mathieu Dumoulin, modifié par Isabelle Angrignon
// Date : 19/09/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramètre
//				 en donnant les classe pour le thème d'un selectable au Li si estThemeJqueryUI est à true.
//               La différence de cette fonction comparée aux autres est quelle ajoute le terme selectable à la classe JQueryUI que le Li se fait attribuer
//               et insère un div dans le li avec sa classe.  Le div contient une autre information formaté différement.
//               On a aussi un endroit pour garder une donnée récupérable si l'item est sélectionné.
function ajouterLi_ToUl_Selectable_Div(idUl, element,idElement, estThemeJqueryUI, texteDiv, classDiv, donneeAGarder) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.setAttribute("placeholder", element);
    liTag.setAttribute("id",idElement);
    if(estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default selectable");
    }
    liTag.appendChild(document.createTextNode(element));
    // Initialisation du div qui va dans le li
    var divDansLi = document.createElement("div");
    divDansLi.setAttribute("class", classDiv);
    divDansLi.appendChild(document.createTextNode(texteDiv));
    divDansLi.setAttribute("placeholder", donneeAGarder);
    // Ajout du div dans le li
    liTag.appendChild(divDansLi);
    document.getElementById(idUl).appendChild(liTag);
}

// Nom : ajouterLi_ToUl_Selectable_TextArea
// Par : Mathieu Dumoulin, modifié par Isabelle Angrignon
// Date : 01/12/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe pour le thème d'un selectable au Li si estThemeJqueryUI est à true.
//               La différence de cette fonction comparée aux autres est quelle ajoute le terme selectable à la classe JQueryUI que le Li se fait attribuer
//               et insère un textArea dans le li avec sa classe ce qui permet le formatage selon un textarea.  On a aussi un endroit pour garder une donnée récupérable si l'item est sélectionné.
function ajouterLi_ToUl_Selectable_TextArea(idUl, element,idElement, estThemeJqueryUI, classTextArea) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.setAttribute("id",idElement);
    if(estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default selectable");
    }
    // Initialisation du textarea qui va dans le li
    var textareaDansLi = document.createElement("textarea");
    textareaDansLi.setAttribute("class", classTextArea);
    $(textareaDansLi).val(element).attr("readonly", true);

  //  $(textareaDansLi).parent("li").click(function(e) {
    /*$("#UlChoixReponse").children("li").click(function() {
        alert(this);
       // $("#UlChoixReponse").children("li:first-child").click();
    });*/

    // Ajout du textarea dans le li
    liTag.appendChild(textareaDansLi);
    document.getElementById(idUl).appendChild(liTag);
}


// Nom : ajouterLi_Questions
// Par : Mathieu Dumoulin
// Date : 27/10/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//	   en donnant les classe pour le thême d'un sortable au Li si estThemeJqueryUI est à true. De plus, elle ajoute un div qui permet d'afficher d'autres informations dans le li
function ajouterLi_AvecDiv(idUl, element,idElement, estThemeJqueryUI, texteDiv, classDiv, donneeAGarder) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.Value = element;
    liTag.setAttribute("id",idElement);
    if(estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default");
    }
    liTag.appendChild(document.createTextNode(element));
    // Initialisation du div qui va dans le li
    var divDansLi = document.createElement("div");
    divDansLi.setAttribute("class", classDiv);
    divDansLi.appendChild(document.createTextNode(texteDiv));
    divDansLi.setAttribute("placeholder", donneeAGarder);
    // Ajout du div dans le li
    liTag.appendChild(divDansLi);

    document.getElementById(idUl).appendChild(liTag);
}
function ajouterLi_AvecDiv_V2(idUl, element,idElement, estThemeJqueryUI, texteDiv, classDiv, donneeAGarder) {
    // Initialisation du li
    var liTag = document.createElement("li");
    liTag.Value = element;
    liTag.setAttribute("id", idElement);
    if (estThemeJqueryUI) {
        liTag.setAttribute("class", "ui-state-default");
    }
    liTag.appendChild(document.createTextNode(element));
    // Initialisation du div qui va dans le li
    var divDansLi = document.createElement("div");
    divDansLi.setAttribute("class", classDiv);
    divDansLi.appendChild(document.createTextNode(texteDiv));
    divDansLi.setAttribute("placeholder", donneeAGarder);
    // Ajout du div dans le li
    liTag.appendChild(divDansLi);
    document.getElementById(idUl).appendChild(liTag);
    // 29 est le nombre de caractère que l'on permet
}

// creeBaliseAvecClasse(baliseACreer, classe)
// Par Mathieu Dumoulin
// Date: 24/09/2014
// Intrant(s) : baliseACreer = "tag" de la balise à créer, classe = classe que la balise va avoir
// Extrant(s) : La balise que la fonction à créée
// Description : Cette fonction créée une balise et lui affecte une classe.
function creeBaliseAvecClasse(baliseACreer, classe) {
	var balise = document.createElement(baliseACreer);
	balise.setAttribute("class", classe);
	return balise;
} 

// creeFrameDynamique
// Par Mathieu Dumoulin modifié par Isabelle Angrignon
// Date : 23/09/14
// Intrant(s) : idDivPrincipal = l'identifiant du pop up
//              pathFichierPHP = Le path du fichier PHP qui représente le contenu du divPrincipal
//              confirmerAvantQuitter = boolean si on doit afficher un avis de fermeture du div dynamique
// Extrant(s) : Le div représentant la page de base du "pop up"
// Description : Cette fonction crée, à l'aide de balises div, un squelette de fenêtre "pop up" avec un fond en ombragé
function creeFrameDynamique(idDivPrincipal, pathFichierPHP,confirmerAvantQuitter) {
	var fondOmbrage = creeBaliseAvecClasse("div", "dFondOmbrage");
	fondOmbrage.setAttribute("id", "dFondOmbrage");
    if (confirmerAvantQuitter == true){
        // Si on click hors du div dynamique ou sur "esc", on demande la permission aavnt de quitter
        fondOmbrage.onmousedown = function(event) {
            swalDemanderDeQuitter();
        };
        $(document).keyup(function (e) {
            if (e.which == 27) {
                swalDemanderDeQuitter();
            }
        });
    }
    else{
        fondOmbrage.onmousedown = function(event) {
            // detach() fait comme la méthode remove() mais ne delete pas les événements liés à l'objet
            $(document).off("keydown");
            $(this).detach();
        };
    }

	var divPrincipale =  creeBaliseAvecClasse("div", "dDivPrincipale");
	// Nécessaire pour empecher l'événement onclick de son parent d'être activé lorsqu'on clic dessus ce div
	divPrincipale.onmousedown = function(event) {  event.stopPropagation(); };
    divPrincipale.setAttribute("id", idDivPrincipal);

	document.body.appendChild(fondOmbrage);
	fondOmbrage.appendChild(divPrincipale);

    ajouterKeyDownFrameDynamique(confirmerAvantQuitter);

    if(pathFichierPHP != null) {
        insererHTMLfromPHP(idDivPrincipal, pathFichierPHP);
    }
	
	return divPrincipale;
}

function swalDemanderDeQuitter(){
    swal({   title: "Quitter ce quiz",
        text: "Vous vous apprêtez à quitter ce quiz. Toute progression sera perdue.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FFA64F",
        confirmButtonText: "Quitter",
        cancelButtonText: "Continuer"
    }, function(){
        // detach() fait comme la méthode remove() mais ne delete pas les événements liés à l'objet
        $(document).off("keydown");
        $("#dFondOmbrage").detach();
    });
}

// insererNouveauDiv
// Par Mathieu Dumoulin
// Date: 03/10/2014
// Intrant(s) : idDiv = id que vous voulez affecter au nouveau div.
//              idParent = id du parent
//              classDiv = classe du nouveau div. Entrer null s'il n'y a pas de classe
// Extrant(s) : Il n'y en a pas
// Description : Cette méthode créée un div dynamiquement, lui affecte l'id idDiv,
//              la classe classDiv (si elle n'est pas nulle) et l'insère dans le parent ayant comme id idParent.
function insererNouveauDiv(idDiv, idParent, classDiv) {
    var parent = document.getElementById(idParent);
    var nouveauDiv = document.createElement("div");
    nouveauDiv.setAttribute("id", idDiv);
    // Ici j'utilise className au lieu de setAttribute car ça me permet d'ajouter plusieurs classes à l'élément
    // sans avoir à modifier le code lorsqu'il y a plusieurs classes
    if(classDiv != null) {
        nouveauDiv.className = classDiv;
    }
    parent.appendChild(nouveauDiv);
}

// creerNouveauCheckBox
// Par Mathieu Dumoulin
// Date: 14/10/2014
// Intrants: idParent = l'identifiant du parent
//           name = le groupe dont le checkbox appartient (correspond à son attribut "name")
//           value = la valeur que le checkbox contient (correspond à son attribut "value")
//           text = le texte que le checkbox va afficher à l'interface
// Description: Cette fonction créée un nouveau CheckBox en limitant son nombre de caractères
//              pour qu'il soit d'une taille raisonnable pour son parent
function creerNouveauInput(typeInput, idParent, name, value, text, tailleDuTexte, isChecked) {
    var li = document.createElement("li");

    var input = document.createElement("input");
    input.setAttribute("type", typeInput);
    input.setAttribute("name", name);
    input.setAttribute("value", value);
    if(isChecked != null) {
        input.setAttribute("checked", "checked");
    }

    li.appendChild(input);
    if(tailleDuTexte != null && text.length > tailleDuTexte) {
        text = text.substr(0,tailleDuTexte) + "...";
    }

    li.appendChild(document.createTextNode(text));
    document.getElementById(idParent).appendChild(li);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////     FONCTIONS POUR PEUPLER/VIDER     ////////////////////////////////////////////////////////////////////////

// insererHTMLfromPHP
// Par Mathieu Dumoulin
// Date: 08/10/2014
// Intrants : idConteneur = l'identifiant du conteneur
// Extrant : Il n'y en a pas
// Description : Cette méthode utilise AJAX pour inserer le contenu HTML du fichier PHP dans le Conteneur.
function insererHTMLfromPHP(idConteneur, pathFichierPHP) {
    $.ajax({
        type: 'GET',
        url: pathFichierPHP,
        async: false,
        dataType: "html",
        success: function(resultat) {
            var selecteur = "#" + idConteneur;
            $(selecteur).html(resultat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "   /////    " + textStatus + "   /////    " + errorThrown);
        }

    });
}

// viderHTMLfromElement
// Par Mathieu Dumoulin
// Date: 08/10/2014
// Description : Cette fonction vide le html de l'élément correspondant à l'id passé en paramètre
function viderHTMLfromElement(idElement) {
    var selecteur = "#" + idElement;
    $(selecteur).html("");
}

// ajouterKeyDownFrameDynamique
// Par Mathieu Dumoulin, modifié par Isabelle Angrignon
// Description : Cette fonction ajoute les événements qui s'appliquent à tous les divs dynamiques qui ne demandent pas de confirmation avant de quitter
function ajouterKeyDownFrameDynamique(confirmerAvantQuitter) {
    if (confirmerAvantQuitter != true) {
        $(document).keydown(function (e) {
            if (e.which == 27) {
                $("#dFondOmbrage").remove();
                $(document).off("keydown");
            }
        });
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// ChercherUsagerAjax
// par : Simon Bouchard
// description : Permet de retrouver un usager par rapport a son numero de DA pour confirmer une action
// parametre : idUsager = id de l'usager dont il faut trouver le nom prénom , functiononTrue = la fonction appelé si l'usager souhaite
// faire une action sur ce compte (le parametre idUsager sera passer aussi a la functionOnTrue) , text = le texte qu'affichera le sweet alert
function ChercherUsagerAjax(idUsager , functionOnTrue, texte) {
        $.ajax({
            type: 'POST',
            url: "Controleur/ChercherUsager.php",
            data: {"idUsager" :idUsager},
            dataType: "json",
            success: function(resultat) {
                if(!resultat.hasOwnProperty('echec') ) {
                    swal({   title: "Êtes-vous sur?",
                        text: "Est-ce bien "+resultat.prenom + " " + resultat.nom + texte,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#FFA64F",
                        confirmButtonText: "GO ! ",
                        closeOnConfirm:false
                    }, function(){
                        functionOnTrue(idUsager);
                    });
                }
                else{
                    swal({   title: "Erreur!",   text: "Le numero de DA est invalide",   type: "error"});
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
            }
        });
}



// reintialiserMotDePasse
// Fait par : Simon Bouchard
// Commencer le : 12/11/2014
// Cette fonction est un appel ajax permettant de réinitialiser un mot de passe
// Fichier appelé :RéinitialiserMotDePasse.php
// Réaction : Affiche un swal qui indique la réussite ou l'échec de l'opération
// Intrant : Le numéro de DA de l'usager dont le mot de passe doit être réinitialiser
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
                swal({   title: "Opération réussie!",   text: "Reinitialisation de mot de passe réussi",   type: "success"});
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}


// setVarSessionAjax
// fait par : Simon Bouchard
// Permet de set un variable de session du serveur php a travers le AJAX
// Parametre: clee= la clée de la variable de session , valeur = la valeur a mettre dans la variable de session
function setVarSessionAjax(clee,valeur){
    $.ajax({
        type: 'POST',
        url: "Controleur/setVarSession.php",
        data: {"clee" :clee,"valeur":valeur},
        dataType: "text",
        async : !1,
        success: function(resultat) {
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + "   /////    " + textStatus + "   /////    " + errorThrown);
        }
    });
}

// getVarSessionAjax
// Permet d'obtenir la valeur de la valeur de session d'une variable de session php
// Parametre : clee = la clée de la variable de session que l'on souhaite obtenir
function getVarSessionAjax(clee){
    return $.ajax({
        type: 'POST',
        url: "Controleur/getVarSession.php",
        data: {"clee" :clee},
        dataType: "text",
        async : !1
    });
}