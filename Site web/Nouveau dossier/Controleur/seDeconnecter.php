<?php
include("Utilitaires.php");
demarrerSession();
redirigerSiNonConnecte();
session_destroy();
header('location: ../index.php');


?>