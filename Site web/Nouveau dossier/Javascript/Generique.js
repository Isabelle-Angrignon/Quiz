// Generique.js
// Par Mathieu Dumoulin
// Date : 15/09/2014
// Description : Contient tout le code Javascript générique de l'application QuizInfo


// Nom : ajouterOption_ToSelect
// Par : Mathieu Dumoulin
// Date : 15/09/2014
// Intrant(s) : String idSelect, String element 
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Select et lui ajoute (en tant qu'attribut value) l'élément passé en paramêtre à l'aide d'une balise option
function ajouterOption_ToSelect(idSelect, element) {
	var optionTag = document.createElement("option");
	optionTag.Value = element;
	// createTextNode permet de mettre du texte représentant notre balise (ce que l'usager voit comme texte)
	optionTag.appendChild(document.createTextNode(element));
	document.getElementById(idSelect).appendChild(optionTag);
}


// Nom : ajouterLi_ToUl
// Par : Mathieu Dumoulin
// Date : 19/09/2014
// Intrant(s) : String idUl, String element, bool estSortable
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Ul et lui ajoute un Li créé dynamiquement comportant le texte (element) passer en paramêtre
//				 en donnant les classe nécessaire à un sortable au Li si estSortable est à true
function ajouterLi_ToUl(idUl, element, estSortable) {
	// Initialisation du li
	var liTag = document.createElement("li");
	liTag.Value = element;
	if(estSortable) {
		liTag.setAttribute("class", "ui-state-default");
		// Initialisation du span contenu dans le li (nécéssaire pour les sortables)
		var spanTag = document.createElement("span");
		spanTag .setAttribute("class", "ui-icon ui-icon-arrowthick-2-n-s");
		liTag.appendChild(spanTag);
	}
	liTag.appendChild(document.createTextNode(element));
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
// Intrant(s) : Il n'y en a pas
// Extrant(s) : Il n'y en a pas
// Description : Cette fonction créée, à l'aide de balises div, un squelette de fenêtre "pop up" avec un fond en ombragé
function creeFrameDynamique() {
	var fondOmbrage = creeBaliseAvecClasse("div", "dFondOmbrage");
	fondOmbrage.setAttribute("id", "fondOmbrage");
	fondOmbrage.onclick = function(event) { 
		// detach() fait comme la méthode remove() mais ne delete pas les événements liés à l'objet
		$(this).detach();
	}
	var divPrincipale =  creeBaliseAvecClasse("div", "dDivPrincipale");
	// Nécessaire pour empecher l'événement onclick de son parent d'être activé lorsqu'on clic dessus ce div
	divPrincipale.onclick = function(event) { event.stopPropagation(); }
	
	document.body.insertBefore(fondOmbrage);
	fondOmbrage.appendChild(divPrincipale);
}


function afficherChargement() {
	var div = document.createElement("div");
	div.setAttribute("id", "divChargement");
	document.body.insertBefore(div);
	
	$("#divChargement").fadeIn(300);
}
