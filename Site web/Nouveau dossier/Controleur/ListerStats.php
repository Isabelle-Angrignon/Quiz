
<?php
header( 'Content-Type:charset=UTF-8');
include("Utilitaires.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleStatistiques.php");

demarrerSession();
redirigerSiNonConnecte('Prof');
header('Content-Disposition: attachment;Filename=QuizInfoStats.csv');
$stats  = obtenirStat();
echo date("Y-m-d");
echo "\n";
$Key = array_keys($stats[0]);
for ( $i = 0 ; $i < count($Key); $i++)
{
    if ($i%2 == 0 ) {
        echo $Key[$i] . ";";
    }
}
echo  "\n";
for ($i = 0 ; $i < count($stats); $i++)
{
    for ($j = 0 ; $j < count($stats[$i])/2; $j++) {
        echo $stats[$i][$j] . ";";
    }
    echo "\n";
}
?>
