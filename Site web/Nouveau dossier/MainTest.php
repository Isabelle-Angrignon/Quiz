<!DOCTYPE html>
<html>

<head>
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");		
		include("Vue/PHP de base/Utilitaires.php");	
	?>
	
	<script>
		$(".contenu").click( function() {
			$.ajax({
				type: 'post',
				url: 'Test.php',
				data: {
					NombreUn: 1,
					NombreDeux: 5
				},
				datatype: "text",
				success: function(reponse) {
					alert(reponse);
				}
			});
		});
	</script>
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