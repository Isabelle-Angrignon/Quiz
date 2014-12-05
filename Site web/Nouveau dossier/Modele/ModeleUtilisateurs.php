<?php
function getStringConnection()
{
    return 'mysql:host=172.17.104.99:8080;dbname=projetquiz';
}

// getConnection
// Par: Mathieu Dumoulin
// date: 13/10/2014
// Description: Cette fonction reçoit un type d'usager en paramètre ("etudiant","prof","admin") et retourne la conexion correspondante
function getConnection()
{
    if(!isset($_SESSION['typeUsager']))
    {
        // Nécessaire pour ne pas faire une boucle de redirection à cause de la fonction redirigerSiDejaConnecte
        unset($_SESSION["idUsager"]);
        $_SESSION['erreur'] = "Vous avez perdu la connexion au serveur. Veuillez vous reconnecter";
        // header("location:index.php") ne marche pas ici car le header est envoyé dès qu'un echo ou un changement d'une variable de session survient.
        // Alors, la page n'est redirigé qu'au prochain chargement de la page. C'est pourquoi on redirige en javascript.
        echo '<script>window.location = "index.php";</script>';
        exit();
    }
    switch($_SESSION['typeUsager'])
    {
        case "Etudiant":
            $bdd = connecterEtudiant();
            break;
        case "Prof":
            $bdd = connecterProf();
            break;
        case "Admin":
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
        $bdd = new PDO(getStringConnection(), 'Etudiant', 'etudiant', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        echo "<script>alert(" . $e->getMessage() . ");</script>";
        return false;
    }
}




?>