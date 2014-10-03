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
        include("Vue/PHP de base/Utilitaires.php");
    ?>
	
  	<script src="Javascript/Generique.js"></script>
  	<script src="Javascript/GererCours.js"></script>
  	<script>
  	/////////////////////////////////////////////////////////////////////////////////////////
  	////// Aide mémoire de Mathieu pour prochaine rencontre 
  	/////////////////////////////////////////////////////////////////////////////////////////
  	////// - Remplir la liste de cours avec la BD
  	////// - Continuer le Pop up dynamique
  	/////////////////////////////////////////////////////////////////////////////////////////
  	/////////////////////////////////////////////////////////////////////////////////////////
	  $(function() {
	    $("#UlQuiz").sortable({
	    	connectWith: "#QuizDropZone",
	    	revert: 150
	    });
	    $("#UlModifQuiz").sortable({
	    	connectWith: "#UlQuestion",
	    	revert: 150
	    });
	    $("#UlQuestion").sortable({
	    	connectWith: "#UlModifQuiz",
	    	revert: 150
	    });
	    $("#QuizDropZone").sortable({
	    	connectWith: "#UlQuiz",
	    	revert: 150
	    });
	    
	    $("#DDL_Cours").selectmenu();
	    $("#UlQuestion").click( function() {
	    	creeFrameDynamique();
	    });
	     $("#AjouterQuestion").click( function() {
	    	var id = "UlQuestion";
	    	ajouterLi_ToUl(id, "Un nouvel Element Bad Ass", true);
		});

	  });
	  /*accept: function(sender) {
	    		return $(this).children("li") == 0;
	    	}*/
	</script>
</head>

<body>

	<?php
        /*demarrerSession();
        redirigerSiNonConnecte();*/
		include("Vue/PHP de base/EnteteSite.php");
		include("Vue/PHP de base/MenuProf.php");
	?>
		
	<div class="contenu">
		<fieldset><select id="DDL_Cours">
                <?php
                    InsererCours();
                ?>
		</select></fieldset>
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
			<div id="ajouterQuiz"></div>
		</div>
		<div id="ListeModifQuiz" class="Liste ListeGererQuiz">
			<div id="QuizDropZone" class="ListeDivElementStyle"></div>
			<ul id="UlModifQuiz">
			</ul>
		</div>
		<div id="ListeGererQuestions" class="Liste ListeGererQuiz">
			<ul id="UlQuestion">
			</ul>
			<div id="AjouterQuestion" class="ListeDivElementStyle">Ajouter une question</div>
		</div>
	</div>
	
	<?php
		include("Vue/PHP de base/BasDePage.php");
	?>
    <script>
        $("#UlQuestion").ready(function() {
            $.ajax({
                type: 'POST',
                url: 'Modele/ListerQuestions.php',
                data: {"Triage":"default", "idCours":4 , "idProprietaire": "420jean"},
                dataType: "json",
                success: function(resultat) {
                    var enonceDeLaQuestion;
                    for(var i = 0; i < resultat.length; ++i) {
                        enonceDeLaQuestion = resultat[i].enonceQuestion;
                        if(enonceDeLaQuestion.length > 25) {
                            enonceDeLaQuestion = enonceDeLaQuestion.substring(0, 25) + "...";
                        }
                        ajouterLi_ToUl_V2("UlQuestion", enonceDeLaQuestion, resultat[i].idQuestion, true);
                    }
                }
            });
        });
    </script>
</body>

</html>