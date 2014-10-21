<?php
include("Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte('Usager');
session_destroy();
header('location: ../index.php');


?>