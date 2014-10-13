<?php
    include("../Controleur/Utilitaires.php");
    include("../Controleur/cFonctionsProf-GererQuiz.php");
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");
    if(!isset($_GET["idQuestion"]))
    {
        trigger_error("Il n'y a aucun identifiant de question passé à ce div dynamique", E_USER_ERROR);
    }
    $maQuestion = getQuestion($_GET["idQuestion"]);
    $enonceQuestion = $maQuestion[0]["enonceQuestion"];
?>

<div id="QuestionConteneur">
    <div id="EnonceQuestion">
        <?php
            echo $enonceQuestion;
        ?>
    </div>
    <div id="reponseConteneur">

    </div>
</div>


<?php

?>