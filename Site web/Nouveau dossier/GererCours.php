<!-- Prof-GererCours
Par: Mathieu Dumoulin
Date: 19/09/2014
Description: Cette interface représente l'interface principale d'un professeur lorsqu'il veut modifier un quiz--> 

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="Vue/CSS/GererCours.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="Vue/CSS/GererSonCompte.css" type="text/css" media="screen" >
	
	<?php

		include("Vue/Template/InclusionJQuery.php");
        include("Vue/Template/InclusionTemplate.php");
        include("Modele/ModeleCours.php");
        include("Modele/ModeleEtudiants.php");
        include("Controleur/cFonctionsCours.php");
        demarrerSession();
        gestionParamChange();
        redirigerSiNonConnecte('Prof');
    ?>
	
  	<script src="Javascript/Generique.js"></script>
  	<script src="Javascript/GererCours.js"></script>
  	<script>

	  $(function() {
          $("#UlCours").sortable({
              connectWith: "#QuizDropZone",
              revert: 150
          });
          $("#UlModifGroupe").sortable({
              connectWith: "#UlEtudiants",
              revert: 150,
              receive: function (event, ui) {
                  inscrireEtudiantCoursAjax($(ui.item).attr('id'), $(ui.item).text().split(" ")[1], $(ui.item).text().split(" ")[0], $("#QuizDropZone").find("li").attr("id"));
              },
              remove: function (event, ui) {
                  desinscrireEtudiantCoursAjax($(ui.item).attr('id'), $("#QuizDropZone").find("li").attr("id"));
              }
          });
          $("#UlEtudiants").sortable({
              connectWith: "#UlModifGroupe",
              revert: 150,
              dropOnEmpty: false
          });
          $("#QuizDropZone").sortable({
              connectWith: "#UlCours",
              revert: 150,
              receive: function (event, ui) {
                  if($("#QuizDropZone").children().length == 2)
                  {
                      $("#QuizDropZone").children().each(function() {
                            if($(this).text() != $(ui.item).text()){
                                $(this).appendTo("#UlCours");
                            }
                      });
                  }
                  //$("#UlCours").sortable("option", "connectWith", false);
                  $("#UlEtudiants").sortable("option", "dropOnEmpty", true);
                  $('#UlModifGroupe').empty();
                  $('#UlEtudiants').empty();
                  remplirUIModifGroupeAjax($(ui.item).attr('id'));
                  remplirUIEtudiantCoursAjax($(ui.item).attr('id'));
                  $('#BTN_GestionGoupe').show();
                  $('#BTN_Cours').hide();

              },
              remove: function (event, ui) {
                  //$("#UlCours").sortable("option", "connectWith", "#QuizDropZone");
                  $("#UlEtudiants").sortable("option", "dropOnEmpty", false);
                  $('#UlModifGroupe').empty();
                  $('#UlEtudiants').empty();
                  ListerEtudiantAjax();
                  $('#BTN_GestionGoupe').hide();
                  $('#BTN_Cours').show();
              }

          });



      });
	</script>
</head>

<body>

	<?php


		include("Vue/Template/EnteteSite.php");
		include("Vue/Template/MenuProf.php");
	?>
		
	<div class="contenu">
		<div id="LBL_ListesGererCours">
			<label id="GererCours" for="ListeCours">Cours d'informatique</label>
			<label id="ModifierGroupe" for="ListeModifGroupe">Modifier votre groupe ici</label>
			<label id="GererEtudiants" for="ListeModifGroupe">Étudiants</label>
		</div>
		<div id="ListeCours"class="Liste ListeGererCours">
			<ul id="UlCours">
             <?php ListerCoursDansUl("UlCours"); ?>

			</ul>
            <div id="BTN_Cours" class="ListeDivElementStyle BoutonDiv">Ajouter un cours</div>
		</div>
		<div id="ListeModifGroupe" class="Liste ListeGererCours">
			<div id="QuizDropZone" class="ListeDivElementStyle"> </div>
			<ul id="UlModifGroupe">

			</ul>
            <div id="BTN_GestionGoupe" class="btn_holder">
                <div id="BTN_CSV"class="ListeDivElementStyle BoutonDiv">CSV</div>
                <div id="BTN_Vider"class="ListeDivElementStyle BoutonDiv">Vider</div>
            </div>
		</div>
		<div id="ListeGererEtudiants" class="Liste ListeGererCours">
			<ul id="UlEtudiants">
            <?php InsererEleves(); ?>
			</ul>
            <div class="BTN_Holder">
			    <div id="BTN_Eleve" class="ListeDivElementStyle BoutonDiv">Ajouter</div>
                <div id="BTN_EleveReinitialiser" class="ListeDivElementStyle BoutonDiv">Reinit. MDP</div>
            </div>
		</div>
	</div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>
 <script>
     $('#BTN_GestionGoupe').hide();
     $( "#BTN_Cours" ).click(function() {
         creeFrameDynamique('divDynamique','Vue/dynamique-CreerCours.php');
     });
     $( "#BTN_CSV" ).click(function() {
         creeFrameDynamique('divDynamique','Vue/dynamique-CSV.php');
     });
     $( "#BTN_Vider" ).click(function() {
         swal({   title: "Êtes-vous sur?",
             text: "Êtes-vous sur de vouloir vider tout les étudiants de ce cours ?",
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "GO ! ",
         }, function(){
             desinscrireToutEtudiantCoursAjax($("#QuizDropZone").find("li").attr("id"));
             $('#UlModifGroupe').empty();
             $('#UlEtudiants').empty();
             ListerEtudiantAjax();
         });

     });
     $( "#BTN_Eleve" ).click(function() {
         creeFrameDynamique('divDynamique','Vue/dynamique-CreerEtudiants.php');
     });
     $( "#BTN_EleveReinitialiser" ).click(function() {
         creeFrameDynamique('divDynamique','Vue/dynamique-ReinitialiserMotDePasseEtudiant.php');
     });

 </script>

</body>

</html>