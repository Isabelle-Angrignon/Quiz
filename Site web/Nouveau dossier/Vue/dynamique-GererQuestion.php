<?php
    include("../Controleur/Utilitaires.php");
    include("../Controleur/cFonctionsProf-GererQuiz.php");
    include("../Modele/ModeleQuestions.php");
    include("../Modele/ModeleUtilisateurs.php");

    if(!isset($_GET["idQuestion"]))
    {
        trigger_error("Il n'y a aucun identifiant de question passé à ce div dynamique", E_USER_ERROR);
    }
    else if($_GET["idQuestion"] != null)
    {
        $maQuestion = getQuestion($_GET["idQuestion"]);
        //$enonceQuestion = $maQuestion[0]["enonceQuestion"];
        $typeQuestion = $maQuestion[0]["typeQuestion"];
    }

?>

<div id="QuestionConteneur">
    <div id="EnonceQuestion" contenteditable="true">
        <?php
            echo isset($enonceQuestion)?$enonceQuestion:"";
        ?>
    </div>
    <div id="reponseConteneur">
        <?php

        ?>
    </div>
</div>


<?php

?>