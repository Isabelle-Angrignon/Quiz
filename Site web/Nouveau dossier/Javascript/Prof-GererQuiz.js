// Prof-GererQuiz.js
// Par Mathieu Dumoulin
// Date : 17/09/2014
// Description : Contient tout le code Javascript spécifique à la page Prof-GererQuiz.php


// creeFrameDynamique
// Par Mathieu Dumoulin
// Date : 23/09/14
// Intrant(s) : Il n'y en a pas
// Extrant(s) : Il n'y en a pas
// Description : Cette fonction créée, à l'aide de balises div, un squelette de fenêtre "pop up" avec un fond en ombragé
function creeFrameDynamique() {
	var fondOmbrage = document.createElement("div");
	fondOmbrage.setAttribute("class", "dFondOmbrage");
	var divPrincipale = document.createElement("div");
	divPrincipale .setAttribute("class", "dDivPrincipale");
	fondOmbrage.appendChild(divPrincipale);
	
}