
<?php
/*
    Nom: ListerQuestions.php
    Par: Mathieu Dumoulin
    Date: 01/10/2014
    Description: Contient l'appel des fonctions reliés au listage de questions pour un professeur lors d'un appel AJAX.
*/
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");

    $triage = $_POST['Triage'];
    $idProprietaire = $_POST['idProprietaire'];
    $idCours = $_POST['idCours'];

    $resultatTriage;
    if($triage == 'default')
    {
        $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire);
    }
    echo $resultatTriage;

?>