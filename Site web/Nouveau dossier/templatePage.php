<!DOCTYPE html>
<html>

<head>
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
		include("Vue/Utilitaires.php"); // recupererSession()

	?>
</head>

<body>

	<?php
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuProf.php");
	?>
	
	<div class="contenu">
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>