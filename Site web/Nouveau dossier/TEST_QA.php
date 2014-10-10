<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Vue/CSS/DynamiqueQuestionARepondre.css" type="text/css" media="screen" >
	<?php
        include("Vue/Template/InclusionJQuery.php");
		include("Vue/Template/InclusionTemplate.php");

	?>
</head>

<body>

	<?php
	//	demarrerSession();
//		redirigerSiNonConnecte();
		include("Vue/Template/EnteteSite.php");
        //faire un if sur $_SESSION["typeUsager"]
		include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
	?>
	
	<div class="contenu">
        <?php
        include("Vue/dynamique-RepondreQuestion.php");
        ?>

        
	</div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>

</body>

</html>