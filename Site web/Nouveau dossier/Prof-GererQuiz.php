<!-- Prof-GererQuiz
Par: Mathieu Dumoulin
Date: 19/09/2014
Description: Cette interface représente l'interface principale d'un professeur lorsqu'il veut modifier un quiz--> 

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="CSS/Prof-GererQuiz.css" type="text/css" media="screen" >
	
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
	?>
	
  	<script src="Javascript/Generique.js"></script>
  	<script src="Javascript/Prof-GererQuiz.js"></script>
  	<script>
	  $(function() {
	    $("#UlQuiz").sortable({
	    	connectWith: "#QuizDropZone",
	    	revert: "valid"
	    });
	    $("#UlModifQuiz").sortable({
	    	connectWith: "#UlQuestion",
	    	revert: "valid"
	    });
	    $("#UlQuestion").sortable({
	    	connectWith: "#UlModifQuiz",
	    	revert: "valid"
	    });
	    $("#QuizDropZone").sortable({
	    	//disabled: "true"
	    });
	    /*$("#QuizDropZone").droppable({
    		accept: "li",
    		 drop: function(ev, ui) {
        		ui.draggable.remove();
    		}
    	});*/
	    $("#DDL_Cours").selectmenu();
	    $(".ListeGererQuiz ul").disableSelection();
	    $(".ListeGererQuiz ul").click( function() {
	    	var id = $(this).attr("id");
	    	ajouterLi_ToUl(id, "Un nouvel Element Bad Ass", true);
	    });
	  });
	  	    	/*hoverClass: "Quiz_DropZone_hover",
	    	accept: function(sender) {
	    		return $(this).children().length == 0;*/

	</script>
</head>

<body>

	<?php
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuProf.php");
	?>
		
	<div class="contenu">
		<fieldset><select id="DDL_Cours"><option value="TousLesCours">Tous les cours</option></select></fieldset>
		<div id="LBL_ListesGererQuiz">
			<label id="GererQuiz" for="ListeQuiz">Mes quiz</label>
			<label id="ModifierQuiz" for="ListeModifQuiz">Modifier votre quiz ici</label>
			<label id="GererQuestions" for="ListeModifQuiz">Mes questions</label>
		</div>
		<div id="ListeQuiz"class="Liste ListeGererQuiz">
			<ul id="UlQuiz">
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
			</ul>
		</div>
		<div id="ListeModifQuiz" class="Liste ListeGererQuiz">
			<li id="QuizDropZone"></li>
			<ul id="UlModifQuiz">
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
			</ul>
		</div>
		
		<div id="ListeGererQuestions" class="Liste ListeGererQuiz">
			<ul id="UlQuestion">
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
			  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
			</ul>
		</div>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>