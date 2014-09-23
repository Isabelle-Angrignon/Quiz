<!DOCTYPE html>
<html>

<head>
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
		include("Modele/Fonctions.php");// validerUsager()
		include("Vue/Utilitaires.php"); // recupererSession()
	?>
	<link rel="stylesheet" href="CSS/Login.css" type="text/css" media="screen" >
</head>

<body>

	<?php		
		recupererSession();
		validerUsager();
		
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuProf.php");
	?>
	
	<div class="contenu">
	<?php
		include("Contenue_Login.php");
	?>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>