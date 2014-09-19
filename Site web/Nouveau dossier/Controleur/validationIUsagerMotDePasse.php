<!--
validationUsagerMotDePasse
Auteur: Isabelle Angringnon
Date: 15 septembre 2014
Intrants: 
	idUsager varchar 10 
	motDePasse varchar 16
Extrant:
	valide int 2 
But:
	Interroge la base de donnée pour valider que le idUsager et le mot de passe sont une combinaison valide.
	Utilise la procédure stockée "validerUsager"
	si oui, génère une session avec le idUsager
	si non, affiche l'alerte de mot de passe / idUsager non valide.
-->


<!DOCTYPE html >
<html>

	<head>
		<meta content="fr-ca" http-equiv="Content-Language" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Validation</title>
	</head>
	
	<body>	
	
		<?php
				
			$bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'Etudiant', 'etudiant');
			
			if (isset($_POST['idUsager']) AND isset($_POST['motDePasse']))
			{
			    $idUsager   = 'idUsager'; 
			    $motDePasse = 'motDePasse';    
			    
			    $requete = $bdd->prepare("CALL validerUsager(?, ?)");
			    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
			    $requete->bindparam(2, $motDePasse , PDO::PARAM_STR,16); 
			       
			    $requete->execute();
			    
			    $estValide = $requete->fetch(); 
			    
			    if($estValide[0] == 1)// si ici, il d=faut sauvegarder le idUsager dans la session+ si prof, eleve+
			    {
			    	// créer une session et afficher la page accueil selon étudiant ou prof
				    echo 'Le idUSer et le mot de passe sont valides';
			    }
			    else
			    {
			    	//afficher alerte
			        echo 'Le idUSer ou le mot de passe n\'est pas valide';			
			    }    
			    
			    $requete->closeCursor();    
			}
			
			else 
			{
				//On n'a pas encore rempli le formulaire
			}
		?>
		
		
		
		<!--   exemple de cryptage de mot de passe
		
		<?php
			if (isset($_POST['login']) AND isset($_POST['pass']))
			{
			    $login = $_POST['login'];
			    $pass_crypte = crypt($_POST['pass']); // On crypte le mot de passe
			
			    echo '<p>Ligne à copier dans le .htpasswd :<br />' . $login . ':' . $pass_crypte . '</p>';
			}
			
			else // On n'a pas encore rempli le formulaire
			{
			?>
			
			<p>Entrez votre login et votre mot de passe pour le crypter.</p>
			
			<form method="post">
			    <p>
			        Login : <input type="text" name="login"><br />
			        Mot de passe : <input type="text" name="pass"><br /><br />
			    
			        <input type="submit" value="Crypter !">
			    </p>
			</form>
		
		<?php
		}
		?> -->
		
		
		
	
	
	</body>

</html>
