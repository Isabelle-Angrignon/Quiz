// Generique.js
// Par Mathieu Dumoulin
// Date : 15/09/2014
// Description : Contient tout le code Javascript générique de l'application QuizInfo


///// fonction anonyme???????
$(function() {
    // Ce bout de code sert à "resize" le menu selon le nombre d'enfant (de balise <a> ) qu'il contient
    $("nav").ready(function() {
        var nbElement = $("nav a").length;
        var format = 100/nbElement;
        $("nav a").each( function() {
            $(this).width(format + "%");
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
function ajouterOption_ToSelect(idSelect, element, texte) {
	var optionTag = document.createElement("option");
	optionTag.setAttribute("value", element);
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

// Nom : ajouterLi_ToUl
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


// Nom : ajouterLi_ToUl
// Par : Mathieu Dumoulin
// Date : 19/09/2014
// Intrant(s) : String idUl, String element,String idElement , bool estThemeJqueryUI
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe pour le thême d'un sortable au Li si estThemeJqueryUI est à true
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
// Par Mathieu Dumoulin
// Date : 23/09/14
// Intrant(s) : idDivPrincipal = l'identifiant du pop up
//              pathFichierPHP = Le path du fichier PHP qui représente le contenu du divPrincipal
//              idQuestion = La question selon laquelle le frame dynamique est relié
// Extrant(s) : Le div représentant la page de base du "pop up"
// Description : Cette fonction créée, à l'aide de balises div, un squelette de fenêtre "pop up" avec un fond en ombragé
function creeFrameDynamique(idDivPrincipal, pathFichierPHP) {
	var fondOmbrage = creeBaliseAvecClasse("div", "dFondOmbrage");
	fondOmbrage.setAttribute("id", "dFondOmbrage");
	fondOmbrage.onmousedown = function(event) {
		// detach() fait comme la méthode remove() mais ne delete pas les événements liés à l'objet
		$(this).detach();
	};

   /* fondOmbrage.onkeydown = function(event) {               												 /////////////////   Ne marche pas car le div ne peut pas avoir le focus.
		alert(event.keyCode);
		// KeyCode 27 == Le boutton escape
		if(event.keyCode == 27){
			$(this).detach();
		}
	};*/
	var divPrincipale =  creeBaliseAvecClasse("div", "dDivPrincipale");
	// Nécessaire pour empecher l'événement onclick de son parent d'être activé lorsqu'on clic dessus ce div
	divPrincipale.onmousedown = function(event) {  event.stopPropagation(); };
    divPrincipale.setAttribute("id", idDivPrincipal);

	document.body.appendChild(fondOmbrage);
	fondOmbrage.appendChild(divPrincipale);

    if(pathFichierPHP != null) {
        insererHTMLfromPHP(idDivPrincipal, pathFichierPHP);
    }
	
	return divPrincipale;
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
function creerNouveauCheckBox(idParent, name, value, text, tailleDuTexte) {
    var li = document.createElement("li");

    var checkbox = document.createElement("input");
    checkbox.setAttribute("type", "checkbox");
    checkbox.setAttribute("name", name);
    checkbox.setAttribute("value", value);

    li.appendChild(checkbox);
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////