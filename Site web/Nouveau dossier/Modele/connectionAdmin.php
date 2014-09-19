<!--
ConnectionAdmin
Auteur: Isabelle Angringnon
Date: 19 septembre 2014
Intrants: 
	aucun
Extrant:
	connecté bool  
But:
	Se connecte à la base de donnée en tant d'admin
	
	Utilise la procédure stockée "validerUsager"
	si oui, génère une session avec le idUsager
	si non, affiche l'alerte usager non valide.
-->

		
<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'Admin', 'admin');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>