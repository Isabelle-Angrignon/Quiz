<!--
Fonctions.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions d'accès à la BD 

-->



<!--
validerUsager
Auteur: Isabelle Angringnon
Date: 15 septembre 2014
But:
	Interroge la base de donnée pour valider que le idUsager et le mot de passe sont une combinaison valide.
	Utilise la procédure stockée "validerUsager"
	si oui, ajoute le idUsager à la session et redirige à l'accueuil selon prof ou étudiant
	si non, affiche l'alerte de mot de passe / idUsager non valide et retourne à la page index.
-->


<?php

	function validerUsager()
	{
				
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
		    	$_SESSION['erreur'] = 'Le idUSer et le mot de passe sont valides';
		    	// aller à la bonne page: admin, prof, etudiant
		    	header('Location: templatePage.php');
		    	//todo				    
		    }
		    else
		    {
		    	//afficher alerte
		    	$_SESSION['erreur'] = 'Le idUSer ou le mot de passe n\'est pas valide';
	
		    	//retourner à index.php
		        //todo		
		    }		    
		    $requete->closeCursor();    
		}		
		else 
		{
			 
		}
		
		unset($bdd);// fermer connection bd	
	}	
?>
