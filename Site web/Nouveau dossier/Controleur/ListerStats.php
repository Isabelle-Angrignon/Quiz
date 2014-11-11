
<?php
header( 'Content-Type:charset=UTF-8');
include("Utilitaires.php");
include("../Modele/ModeleUtilisateurs.php");
include("../Modele/ModeleStatistiques.php");

demarrerSession();
redirigerSiNonConnecte('Prof');
header('Content-Disposition: attachment;Filename=potato.csv');
$sortie = "";
$stats  = obtenirStat();
$sortie = date("Y-m-d");
$sortie .= "\n";
$Key = array_keys($stats[0]);
for ( $i = 0 ; $i < count($Key); $i++)
{
    if ($i%2 == 0 ) {
        $sortie .= $Key[$i] . ";";
    }
}
$sortie = $sortie . "\n";
for ($i = 0 ; $i < count($stats); $i++)
{
    for ($j = 0 ; $j < count($stats[$i])/2; $j++) {
        $sortie .= $stats[$i][$j] . ";";
    }
    $sortie = $sortie . "\n";
}
echo $sortie;
?>
