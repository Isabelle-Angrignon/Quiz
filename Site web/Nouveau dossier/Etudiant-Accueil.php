<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="CSS/Etudiant-Accueil.css" type="text/css" media="screen" >
	
	<?php 
		include("Vue/PHP de base/InclusionTemplate.php");
		include("Vue/PHP de base/InclusionJQuery.php");
		include("Vue/PHP de base/Utilitaires.php");		
	?>

    <script>
        // fait quoi
        $(function() {
            $("#DDL_Cours").selectmenu();
            $("#DDL_Cours").load(function() {
                ajouterOption_ToSelect("DDL_Cours","Un premier cours");
                ajouterOption_ToSelect("DDL_Cours","Un second cours");
                ajouterOption_ToSelect("DDL_Cours","Un troisième cours");
            });

            $("#UlQuiz").selectable();
            $("#UlQuiz").load(function() {
                ajouterLi_ToUl("UlQuiz","Un premier titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un second titre de quiz",true);
                ajouterLi_ToUl("UlQuiz","Un troisième titre de quiz",true);
            });
        });
    </script>

</head>

<body>

	<?php
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuEtudiant.php");
		demarrerSession();
		redirigerSiNonConnecte();		
	?>

	<div class="contenu">


        Formatifs:
        <fieldset >
            <select id="DDL_Cours">
            </select>
        </fieldset>


        <div class="cadre_Liste" id="types_quiz">
            <p class="titre" content="Répondre à mes quiz:"></p>
            <div class="cadre_Liste" id="liste_Quiz_Formatifs" >
                <p class="titre" content="Formatifs:"></p>
                <ul id="UlQuiz"></ul>


            </div>

        </div>



    </div>

	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>

</body>

</html>