
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
    isset($_POST['idCours'])?$idCours = $_POST['idCours']: $idCours = "";
    isset($_POST['idQuiz'])?$idQuiz = $_POST['idQuiz']: $idQuiz = "";

    $resultatTriage;
    if($triage == 'default')
    {
        $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire);
    }
    else if($triage == "selonQuiz")
    {
        $resultatTriage = listerQuestionsPasDansCeQuiz($idQuiz, $idProprietaire, $idCours,"" /* TODO RESTE À CHERCHER LE TYPE QUIZ */  );
    }
    echo $resultatTriage;

?>