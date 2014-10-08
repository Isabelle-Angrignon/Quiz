<?php
function getStringConnection()
{
    return 'mysql:host=172.17.104.99:8080;dbname=projetquiz';
}

//pour les méthodes de connection:  crypter mdp????
/*	Retourne une connection à la base de donnée en tant que professeur */
function connecterProf()
{
    //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Professeur', 'prof'
    try
    {
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
    }
    catch (Exception $e)
    {
        echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
    }
}

/*  Retourne une connection à la base de donnée en tant qu'admin */
function connecterAdmin()
{
    try
    {
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
    }
    catch (Exception $e)
    {
        echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
    }
}

/*  Retourne une connection à la base de donnée en tant qu'étudiant */
function connecterEtudiant()
{
    try
    {
        //'mysql:host=172.17.104.99:8080;dbname=projetquiz', 'Etudiant', 'etudiant'
        $bdd = new PDO(getStringConnection(), 'Admin', 'admin',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $bdd;
    }
    catch (Exception $e)
    {
        echo 'alert(' .$e->getMessage(). ' ); ';
        return false;
    }
}
?>