<?php
include("Utilitaires.php");
demarrerSession();
$clee = $_POST['clee'];

if(isset($_SESSION[$clee]))
{
    echo $_SESSION[$clee];
}
else{
    echo "undefined";
}