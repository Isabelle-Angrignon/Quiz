
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

echo 'POUR UTILISER LES STATS:
***Nous n\'utilisons pas les parmetres d\'importation de csv par defauts d\'Excel.
***Veuillez suivre les etapes suivantes pas a pas.
***Les accents sont volontairement omis pour faciliter la comprehension de ceux qui
***n\'utilisent pas cette procedure.

Ouvrir un fichier vide Excel.
Cliquer sur l\'onglet "Donnees".
Puis sur l\'outil "A partir du texte".
Selectionner le fichier "QuizInfoStats.csv" le plus recent et "Importer".
Il devrait etre dans votre dossier "Telechargements".
Selectionner "Delimite".
Choisir a quelle ligne vous voulez commencer l\'importation selon si vous voulez enlever les instructions en entete.
Choisir "Origine du fichier:"  "65001: Unicode (UTF-8)".
Cliquer "Suivant".
Choisir "Separateurs  -Autre:" et mettre le symbole ¦  (ctrl+alt+7 sur clavier "Francais(Canada)" ).
Cliquer "Suivant".
A l\'etape 3 , vous pouvez donner un type de donnee a vos colonnes si necessaire.
Par defaut, tout est standard donc les nombres seront consideres comme tel et vous pourrez faire des formules.
Cliquer "Terminer" puis "OK".

POUR FILTRER ET TRIER VOS DONNEES:
Dans l\'onglet "Donnees", selectionnez la ligne de titre (ligne 4) et cliquez sur "Filtrer".
Utilisez ensuite les menus deroulants dans chaque entete de colonne pour filtrer et trier selon vos besoins.
';

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
