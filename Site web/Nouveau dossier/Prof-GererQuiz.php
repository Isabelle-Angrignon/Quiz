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
	    $( "#ListeQuiz" ).sortable();
	    $("#DDL_Cours").selectmenu();
	    $( "#ListeQuiz" ).disableSelection();
	  });
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
		<ul id="ListeQuiz" class="Liste ListeGererQuiz">
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
		</ul>
		
		<ul id="ListeModifQuiz" class="Liste ListeGererQuiz">
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
		  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
		</ul>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>