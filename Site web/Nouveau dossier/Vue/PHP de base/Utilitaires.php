<!--
Fonctions.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions génériques 

-->


<?php
	// L'équivalent du classique getInstance d'un singleton de session
	function demarrerSession()
	{
		session_start();		
	}
	
	//Utilisé à la page index...
	//Vérifie si on a une session connecté.  Si oui, nous redirige 
	//vers notre page d'accueil selon qu'on est prof ou étudiant.	
	function redirigerSiDejaConnecte()
	{
		if (isset($_SESSION['idUsager']))
		{			
			redirigerUsager();			
		}		
	}
	
	//Utiliser à chaque page.
	//Vérifie si on a une session connecté.  Si non, nous redirige 
	//vers la page d'index.	
	function redirigerSiNonConnecte()
	{
		if (!isset($_SESSION['idUsager']))
		{			
			header('Location: Index.php');		
		}		
	}
	
	

//Détermine notre type d'usager: les profs d'info commencent tous pas 420
function redirigerUsager()
	{
		$usager = $_SESSION['idUsager'];
		        
        if ('4' == $usager[0])
        {
            //Prof
            $_SESSION['typeUsager'] = 'prof';
            //redirect
            header('Location: Prof-GererQuiz.php');
        }
        else
        {
            //etudiant
            $_SESSION['typeUsager'] = 'etudiant';
            //redirect
            header('Location: Etudiant-Accueil.php');
        }       
	}				
?>

