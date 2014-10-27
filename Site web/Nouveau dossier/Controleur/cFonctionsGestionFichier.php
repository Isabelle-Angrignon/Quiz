<!-- Upload d'un fichier php -->


<?php
    include("../Controleur/Utilitaires.php");
	include("../Modele/ModeleInscriptionsEtudiantCours.php");
    include("../Modele/ModeleUtilisateurs.php");
    demarrerSession();
    redirigerSiNonConnecte('Prof');

	$nomFichier = UploadFile();
	LireCSV($nomFichier);
	unlink('..\FichierCSV\\' . $nomFichier);
	//Fait par Simon Bouchard  
	//Intrant : Aucun
	//Extrant : Aucun mais un fichier sera copier dans le répertoire FichierCSV
	//2014-09-24
	//Permet de televerser un fichier
	function UploadFile()
	{
		if ($_FILES['file']['error'] > 0) {
	 		echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
	 	else {
				echo 'Upload: ' . $_FILES['file']['name'] . '<br>';
				echo 'Type: ' . $_FILES['file']['type'] . '<br>';
				echo 'Size: ' . ($_FILES['file']['size'] / 1024) . ' kB<br>';
				echo 'Stored in: ' . $_FILES['file']['tmp_name'] . '<br>';	
				move_uploaded_file($_FILES['file']['tmp_name'],
				'C:\Users\QUIZ\Documents\GitHub\Quiz\Site web\Nouveau dossier\FichierCSV\\' . $_FILES['file']['name']);
				echo 'Stored in: ' . 'C:\Users\QUIZ\Documents\GitHub\Quiz\Site web\Nouveau dossier\FichierCSV\\' . $_FILES['file']['name'];
	    }
	    
	    return $_FILES['file']['name'];
    }
    // Fait par : Simon Bouchard
    // Intant: Nom du fichier
    // Extrant : Aucun 
    // 2014-09-24
    // Permet de lire un fichier CSV et d'insérer un élèves / le lier a son cours
    function LireCSV($nomFichier)
    {
    	$leFichier = fopen('..\\FichierCSV\\' . $nomFichier,'r');
    	$ligne = fgets($leFichier);
    	if (ValiderFichier($ligne))
    	{
    		while(!feof($leFichier))
    		{
                try {
                    $ligne = fgets($leFichier);
                    $parametre = explode(';', utf8_encode($ligne));
                    InscrireEtudiantCours($parametre[2], $parametre[1], $parametre[0], $_POST['cours'], $_SESSION['idUsager']);
                }
                catch (PDOException $e)
                {}
    		}
    	}
    	else
    	{
    		echo'Le fichier est invalide ' . '<br>';
    	}
        header('Location: ../GererCours.php');
    
    }
    
    //Fait par : Simon Bouchard
    // Intrant : La ligne a gerer 
    // Extrant : Le traitement de la ligne a réussi
    // 2014-09-24
    // 
    function GererLigneEleve($ligne )
    {	
    	
    	//ajouterUsager();
    }
    
    
    // Fait par : Simon Bouchard
    // Intrant : La premiere ligne du fichier csv
    // Extrant : Si le fichier est valide 
    // 2014-09-24
    // Vérifie si le fichier CSV est valide
    function ValiderFichier ( $premiereLigneCSV)
    {
    	return true;
    }
    
?>