
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
    isset($_POST['typeQuiz'])?$typeQuiz = $_POST['typeQuiz']: $typeQuiz = "";
    isset($_POST['filtreEnonce'])?$filtreEnonce = $_POST['filtreEnonce']: $filtreEnonce="";

    $resultatTriage;
    if($triage == 'default')
    {
        $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire, $filtreEnonce);
    }
    else if($triage == "pasDansCeQuiz")
    {
        if($idQuiz != "" && isset($idProprietaire) && $idCours != "" && $typeQuiz != "")
        {
            $resultatTriage = listerQuestionsPasDansCeQuiz($idQuiz, $idProprietaire, $idCours, $typeQuiz, $filtreEnonce );
        }
        else
        {
            echo "Erreur dans les variables passées pour le listage des questions pas dans le quiz qui ce fait modifier en ce moment.";
        }

    }
    else if($triage == "selonQuiz")
    {
        if($idQuiz != "" && isset($idProprietaire))
        {
            $resultatTriage = listerQuestionsDunQuiz($idQuiz, $idProprietaire);
        }
        else
        {
            echo "Erreur dans les variables passées pour le listage selon un quiz.";
        }
    }
    echo $resultatTriage;

?>