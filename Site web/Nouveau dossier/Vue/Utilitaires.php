<!--
Fonctions.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions génériques 

-->


<?php
	// L'équivalent du classique getInstance d'un singleton de session
	function recupererSession()
	{
		if (!isset($_SESSION['Connect']))
		{
			session_start();
			$_SESSION['Connect'] = 'oui';
		}
	}
	
	
	//Vérifie si on a une session connecté.  Si oui, nous redirige 
	//vers notre page d'accueil selon qu'on est prof ou étudiant.	
	function validerDejaConnecte()
	{
		if (isset($_SESSION['idUsager']))
		{			
			redirigerUsager();			
		}
	}
	
	//Détermine notre type d'usager: les profs d'info commencent tous pas 420
/**
 *
 */
function redirigerUsager()
	{
		$usager = '420';//$_SESSION['idUsager'];
		$t = substr ( $usager, 0 , 1 );

        if (!empty($t)) {
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
	}				
?>

