<?php
function getStringConnection()
{
    return 'mysql:host=172.17.104.99:8080;dbname=projetquiz';
}

// getConnection
// Par: Mathieu Dumoulin
// date: 13/10/2014
// Description: Cette fonction reçoit un type d'usager en paramètre ("etudiant","prof","admin") et retourne la conexion correspondante
function getConnection($typeUsager)
{
    switch($typeUsager)
    {
        case "etudiant":
            $bdd = connecterEtudiant();
            break;
        case "prof":
            $bdd = connecterProf();
            break;
        case "admin":
            $bdd = connecterAdmin();
            break;
    }

    return $bdd;
}

//pour les méthodes de connection:  crypter mdp????
/*	Retourne une connection à la base de donnée en tant que professeur */
function connecterProf()
{

    //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Professeur', 'prof'
    try
    {
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    }
    catch (PDOException $e)
    {
        header('Location: APropos.php');
    }
}

/*  Retourne une connection à la base de donnée en tant qu'admin */
function connecterAdmin()
{
    try
    {
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    }
    catch (PDOException $e)
    {
        echo "<script>alert(" . $e->getMessage() . ");</script>";
        return false;
    }
}

/*  Retourne une connection à la base de donnée en tant qu'étudiant */
function connecterEtudiant()
{
    try {
        //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Etudiant', 'etudiant'
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        echo "<script>alert(" . $e->getMessage() . ");</script>";
        return false;
    }
}




?>