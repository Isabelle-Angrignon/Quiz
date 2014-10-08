<!--
Fonctions.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions d'accès à la BD 

-->

<?php

function ajouterUsager($id, $prenom, $nom)
{
	// a retirer et mettre connecterProf
    $bdd = connecterProf();
	if (isset($id) AND isset($prenom) AND isset($nom))
	{
		$requete = $bdd->prepare("CALL ajouterUsager(?, ?, ?)");
	    $requete->bindparam(1, $id, PDO::PARAM_STR,10);
	    $requete->bindparam(2, $prenom, PDO::PARAM_STR,30); 
	    $requete->bindparam(3, $nom, PDO::PARAM_STR,50);
	       
	    $requete->execute();
	    
	    $ligneAffectee = $requete->fetch(); 
	    $requete->closeCursor();

	    return $ligneAffectee;
	}
    unset($bdd);
}

/*validerUsager
But:
	Interroge la base de donnée pour valider que le idUsager et le mot de passe sont une combinaison valide.
	Utilise la procédure stockée "validerUsager"
	si oui, ajoute le idUsager à la session et redirige à l'accueuil selon prof ou étudiant
	si non, affiche l'alerte de mot de passe / idUsager non valide et retourne à la page index.  */
function validerUsager()
{				
	// a retirer et mettre connecterEtudiant
	$bdd = connecterEtudiant();

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
	    	$_SESSION['idUsager'] = $idUsager;
	    	$_SESSION['erreur'] = 'Le nom d\'usager et le mot de passe sont valides';
	    	// aller à la bonne page: admin, prof, etudiant
	    	redirigerUsager();		    					    
	    }
	    else
	    {
	    	//afficher alerte
	    	$_SESSION['erreur'] = 'Le nom d\'usager ou le mot de passe n\'est pas valide';
	    }		    
	    $requete->closeCursor();    
	}			
	unset($bdd);// fermer connection bd	
}	



function getStringConnection()
{
    return 'mysql:host=172.17.104.99:8080;dbname=projetquiz';
}

//pour les méthodes de connection:  crypter mdp????
/*	Retourne une connection à la base de donnée en tant que professeur */
function connecterProf()
{
    //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Professeur', 'prof'
    try
    {
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
    }
    catch (Exception $e)
    {
        echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
    }
}

/*  Retourne une connection à la base de donnée en tant qu'admin */
function connecterAdmin()
{
	try
	{
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
	}
	catch (Exception $e)
	{
	    echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
	}
}

/*  Retourne une connection à la base de donnée en tant qu'étudiant */
function connecterEtudiant()
{
	try
    {
        //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Etudiant', 'etudiant'
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
    }
    catch (Exception $e)
    {
        echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
    }
}

?>
