<?php

include("..//Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Etudiant');

unset($_SESSION['listeQuestions']);
unset($_SESSION['infoQuestion']);
unset($_SESSION['listeReponses']);

?>