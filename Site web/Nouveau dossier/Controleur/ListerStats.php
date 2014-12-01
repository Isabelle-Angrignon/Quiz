
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  ListetStats.php
//  Fait par : Simon Bouchard
//  Commenter le : 12/11/2014
//
//  Description :
//  Télécharge un fichier CSV contenant tout les stats
//
//  Retour : CSV
//
////////////////////////////////////////////////////////////////////////////////////////////////////
header( 'Content-Type:charset=UTF-8');
include("Utilitaires.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleStatistiques.php");

demarrerSession();
redirigerSiNonConnecte('Prof');
header('Content-Disposition: attachment;Filename=QuizInfoStats.csv');
$stats  = obtenirStat();
echo date("Y-m-d"); // La date de création du fichier comme première ligne du fichier
echo "\n";
$Key = array_keys($stats[0]);
for ( $i = 0 ; $i < count($Key); $i++)      // Crée un header pour les colonnes
{
    if ($i%2 == 0 ) {
        echo $Key[$i] . "¦";
    }
}
echo  "\n";
for ($i = 0 ; $i < count($stats); $i++)         // Boucle pour remplir les stats
{
    for ($j = 0 ; $j < count($stats[$i])/2; $j++) {
        if($j != 10) {
            echo $stats[$i][$j] . "¦";
        }
        else{
            echo str_replace("\n"," ", $stats[$i][$j] ) . "¦";
        }
    }
    echo "\n";
}
?>
