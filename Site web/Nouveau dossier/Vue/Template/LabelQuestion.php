
<!-- Appelé par model pour générer le label "list item" pour une question.

On lui passe minimum deux params:

  value = idQuestion
  text = enonceQuestion 
  
optionnel: prendre des tags autant qu'il y en a... !!!! :/

-->
<li id=<?php echo $_GET['idQuestion'] ?> class="ui-state-default" >
	
	<span class="ui-icon ui-icon-arrowthick-2-n-s">
	</span>
	<?php echo $_GET['enonceQuestion'] ?>
	
</li>




-