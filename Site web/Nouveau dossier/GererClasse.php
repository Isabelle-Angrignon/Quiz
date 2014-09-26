<!DOCTYPE html>
<html>

<head>
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
	?>
</head>

<body>

	<?php
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuProf.php");
	?>
	
	<div class="contenu">
		<form action="GestionFichier.php" method="post"
		enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file" accept=".csv"><br>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>