<?php

/*ModeleUsagers.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions d'accès à la table usager
*/

//AjouterUsager
//Intrant : Id = Le numero de de DA de l'usager , prenom= prenom de l'usager , nom = nom de l'usager
//Extrant : Retourne le nom de lignes affecté
//Permet d'ajouter un usager de base qu'il soit prof ou non. Le numero de commence par 420 dans le cas d'un prof
//

function ajouterUsager($id,$Password , $nom, $prenom)
{
	// a retirer et mettre connecterProf
    $reussi = 0;
    $bdd = getConnection();
	if (isset($id) AND isset($prenom) AND isset($nom))
	{
		$requete = $bdd->prepare("CALL ajouterUsager(?, ? , ?, ?)");
	    $requete->bindparam(1, $id, PDO::PARAM_STR,10);
        $requete->bindparam(2, $Password, PDO::PARAM_STR,255);
	    $requete->bindparam(3, $prenom, PDO::PARAM_STR,30);
	    $requete->bindparam(4, $nom, PDO::PARAM_STR,50);
	       
	    $requete->execute();

        $reussi = $requete->rowCount();

	    $requete->closeCursor();
        unset($bdd);

	}
    else
    {
        unset($bdd);
    }
    return $reussi;
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
	$bdd = getConnection();

	if (isset($_POST['nomUsager']) AND isset($_POST['motDePasse']))
	{
	    $idUsager   = $_POST['nomUsager']; 
	    $motDePasse = $_POST['motDePasse'];    
	    
	    $requete = $bdd->prepare("CALL validerUsager(?)");
	    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
	       
	    $requete->execute();
	    
	    $infoUsager = $requete->fetch();
	    
	    if(password_verify($_POST['motDePasse'],$infoUsager['motDePasse']))// si ici, il faut sauvegarder le idUsager dans la session+ si prof, eleve+
	    {
	    	// mettre le idUsager dans cookie de session
	    	$_SESSION['idUsager'] = $idUsager;

	    	unset($_SESSION['erreur']);
            $_SESSION['Nom'] = $infoUsager['nom'];
            $_SESSION['Prenom'] = $infoUsager['prenom'];
            $_SESSION['ParamChange'] = $infoUsager['paramchange'];
            definirTypeUsager($idUsager, $infoUsager['estAdmin']);
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

//recupererAdresseEmail
// Fait par: Simon Bouchard
// Intrant : L'id usager possédant le e-mail
// Extrant : Le e-mail de l'usager même si il n'en a pas
// Fonction permettant de trouver l'adresse e-mail d'un usager.

function recupererAdresseEmail($idUsager){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL recupererEmailUsager(?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);

    $requete->execute();

    $infoUsager = $requete->fetch();

    return $infoUsager;
}

function ModifierAdresseEmail($idUsager, $NouveauEMail){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL ModifierEmail(? , ?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
    $requete->bindparam(2, $NouveauEMail, PDO::PARAM_STR,255);

    $requete->execute();




}

function ModifierMotPasse($idUsager, $NouveauMotPasse){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL ModifierMotDePasse(? , ?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
    $requete->bindparam(2, $NouveauMotPasse, PDO::PARAM_STR,255);

    $requete->execute();

    $reussi = $requete->rowCount();

    return $reussi;

}

function RecupererMotPasse($Pid){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL recupererMotPasse(?)");
    $requete->bindparam(1, $Pid, PDO::PARAM_STR,10);

    $requete->execute();

    $infoUsager = $requete->fetch();

    return $infoUsager;
}

function setParamChange($idUsager,$estChanger)
{
    $paramChange = -1;
    if ($estChanger == true){ $paramChange = 1;} else{ $paramChange = 0;}
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL ModifierParamChange(? , ?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);
    $requete->bindparam(2, $paramChange, PDO::PARAM_INT);

    $requete->execute();
}

function recupererParamChange($idUsager)
{
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL recupererParamChange(?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);

    $requete->execute();

   //// 1 si modifié et 0 sinon...

    $infoUsager = $requete->fetch();

    return $infoUsager;
}

function ChercherUsager($idUsager){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL ChercherUsager(?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);

    $requete->execute();

    $retour = $infoUsager = $requete->fetch();

    if($infoUsager['nom'] != null)// si ici, il d=faut sauvegarder le idUsager dans la session+ si prof, eleve+
    {
        $retour = $infoUsager;
    }
    else
    {
        $retour = null;
    }
    $requete->closeCursor();

    unset($bdd);// fermer connection bd
    return $retour;
}

function SupprimerUnCompte($numeroDA){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL supprimerCompte(?)");
    $requete->bindparam(1, $numeroDA, PDO::PARAM_STR,10);

    $requete->execute();

    $reussi = $requete->rowCount();

    return $reussi;
}

function nommerAdmin($idUsager){
    $bdd = getConnection();
    $requete = $bdd->prepare("CALL nommerAdmin(?)");
    $requete->bindparam(1, $idUsager, PDO::PARAM_STR,10);

    $requete->execute();

    $reussi = $requete->rowCount();

    return $reussi;
}

?>
