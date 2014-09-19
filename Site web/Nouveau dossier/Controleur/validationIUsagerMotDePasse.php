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

	
		<?php
			if (isset($_POST['Connect']))
			{
				session_start();
				$_SESSION['Connect'];
			}
				
			$bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');
			
			if (isset($_POST['nomUsager']) AND isset($_POST['motDePasse']))
			{
			    $idUsager   = $_POST['nomUsager']; 
			    $motDePasse = $_POST['motDePasse'];    
			    
			    $requete = $bdd->prepare("CALL validerUsager(?, ?)");
			    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
			    $requete->bindparam(2, $motDePasse , PDO::PARAM_STR,16); 
			       
			    $requete->execute();
			    
			    $estValide = $requete->fetch(); 
			    
			    if($estValide[0] == 1)// si ici, il d=faut sauvegarder le idUsager dans la session+ si prof, eleve+
			    {
			    	// mettre le idUsager dans cookie de session
			    	$_SESSION['idUsager'] = 'nomUsager';
			    	$_SESSION['message'] = 'Le idUSer et le mot de passe sont valides';
			    	// aller à la bonne page: admin, prof, etudiant
			    	echo 'Sa marche';
			    	//http_redirect("templatePage.php", array(""), true, HTTP_REDIRECT_PERM);
			    	//todo				    
			    }
			    else if ($estValide[0] == 0)
			    {
			    	//afficher alerte
			    	$_SESSION['erreur'] = 'Le idUSer ou le mot de passe n\'est pas valide';
			    	echo 'damn';
			    	//retourner à index.php
			        //todo		
			    }
			    else
			    {
			    	echo 'Very damn';
				}    
			    
			    $requete->closeCursor();    
			}
			
			else 
			{
				 
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
		