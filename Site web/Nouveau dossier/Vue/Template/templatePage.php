<?php
//template.php
//La page de base en php sur laquel devrait être basée toute les autres pages !
//
?>

<!DOCTYPE html>
<html>

<head>
	<?php
        include("Vue/Template/InclusionJQuery.php");
		include("Vue/Template/InclusionTemplate.php");
	?>
</head>

<body>

	<?php
		demarrerSession();
		redirigerSiNonConnecte();
		include("Vue/Template/EnteteSite.php");
        //faire un if sur $_SESSION["typeUsager"]
		include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
	?>
	
	<div class="contenu">



	</div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>

</body>

</html>