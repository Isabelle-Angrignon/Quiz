<div id="alerte" class="Alerte">
			<?php if ((isset($_SESSION['erreur'])) && (!empty($_SESSION['erreur'])))
					{
						echo $_SESSION['erreur'];
					}
					else
					{
						echo 'Veuillez vous connecter';
					} 
			?>
		</div>
		<div id="login">
			<p id="titreConnexion">Connexion</p>
			
			<form id="login_Form" method="post" action="index.php">
				<div id="loginLabels">
					<p id="nomUsager">Nom d'usager </p>
					<p id="motDePasse">Mot de passe </p>
				</div>
				
				<div id="loginTextFields">
					<input type="text" id="TBNomUsager" name="nomUsager" />
					<input type="text" id="TBMotDePasse" name="motDePasse" />
				</div>
				
				<input type="submit" id="btnConnexion" value="Se connecter"/>
			</form>

			
			<p id="linkLostAcount"><a href="#">Mot de passe oublié ? </a></p>
			
			
		
		</div>
