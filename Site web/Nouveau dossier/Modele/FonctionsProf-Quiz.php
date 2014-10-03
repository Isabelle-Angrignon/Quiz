<?php
/**
 * prendreListeQuestions
 * Par: Mathieu Dumoulin
 * Date: 03/10/2014
 * Description: Ce fichier contient toutes les fonctions spécifiques à la page Prof-GererQuiz.php
 */

    // Nom: prendreListeQuestion
    // Par: Mathieu Dumoulin
    // Intrants: $idCours = identifiant du cours en question. $idProprietaire = identifiant du professeur en question
    // Extrants: Le résultat de la procédure, sous forme de JSON
    // Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions()
    function trieParDefaultQuestions($idCours, $idProprietaire)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $requete = $bdd->prepare("CALL listerQuestions(?,?)");

        $requete->bindParam(1, $idCours, PDO::PARAM_INT,10);
        $requete->bindParam(2, $idProprietaire, PDO::PARAM_STR, 10);

        $requete->execute();
        $resultat = $requete->fetchAll();

        $requete->closeCursor();
        unset($bdd);

        return json_encode($resultat);
    }
    // Nom: remplirListeQuestions
    // Par: Mathieu Dumoulin
    // Intrants: $idCours = identifiant du cours en question.
    //           $idProprietaire = identifiant du professeur en question
    //           $triage = le type de triage à effectuer
    // Extrants: Le résultat de la procédure, sous forme de JSON
    // Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions()
    function remplirListeQuestions($idCours, $idProprietaire, $triage = 'default')
    {
        if($triage == 'default')
        {
            $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire);
        }
        echo "<script>traiterJSONQuestions(" . $resultatTriage .");</script>";
    }


?>