﻿// Nom : ajouterOption_ToSelect
// Par : Mathieu Dumoulin
// Date : 15/09/2014
// Intrant(s) : String idSelect, String element 
// Extrant(s) : Il n'y a pas d'extrant
// Description : Cette fonction prend l'id d'une balise Select et lui ajoute l'élément passé en paramêtre à l'aide d'une balise option
function ajouterOption_ToSelect(idSelect, element) {
	var optionTag = document.createElement("option");
	optionTag.Value = element;
	// createTextNode permet de mettre du texte représentant notre balise (ce que l'usager voit comme texte)
	optionTag.appendChild(document.createTextNode(element));
	document.getElementById(idSelect).appendChild(optionTag);
}


function onClick() {
	ajouterOption_ToSelect("DDL_Cours", "jambon");
	ajouterOption_ToSelect("DDL_Cours", "patate");
}