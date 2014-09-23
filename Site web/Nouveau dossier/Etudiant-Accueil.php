<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="CSS/Etudiant-RepondreQuestionFrame.css" type="text/css" media="screen" >
	
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
	?>

</head>

<body>

	<?php
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuEtudiant.php");
	?>
	<div class="Cadre"	>
		<!--drop down liste de mes cours  -->
		<div class="Style-Liste"></div>
			Répondre à mes quiz:
			
			<div id="contenu" onclick="OuvrirQuiz">
				<fieldset><select id="DDL_Cours"></select></fieldset>
				Formatifs:
				<ul id="Liste">
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 1</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 2</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 3</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 4</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 5</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 6</li>
				  <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Quiz 7</li>
				</ul>
			</div>
		</div>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>