
<?php
/*
Nom: ListerQuestions.php
Par: Mathieu Dumoulin
Date: 01/10/2014
Description: Contient toutes les fonctions reliés au listage de questions pour un professeur.
*/

    $triage = $_POST['Triage'];
    $idProprietaire = $_POST['idProprietaire'];
    $idCours = $_POST['idCours'];

    $resultatTriage;
    if($triage == 'default')
    {
        $resultatTriage = trieParDefault($idCours, $idProprietaire);

    }
    echo $resultatTriage;

    function trieParDefault($cours, $proprietaire)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $requete = $bdd->prepare("CALL listerQuestions(?,?)");

        $requete->bindParam(1, $cours, PDO::PARAM_INT,10);
        $requete->bindParam(2, $proprietaire, PDO::PARAM_STR, 10);

        $requete->execute();
        $resultat = $requete->fetchAll();

        $requete->closeCursor();
        unset($bdd);

        return json_encode($resultat);

    }
?>