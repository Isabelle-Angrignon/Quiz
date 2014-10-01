<?php
/**
 * Created by PhpStorm.
 * User: Isabelle
 * Date: 2014-09-30
 * Time: 13:03
 */
function genererQuestionsAleatoires($cours)
{
    // a retirer et mettre connecterEtudiant
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');

    if (isset($cours))
    {
        $requete = $bdd->prepare("CALL genererQuestionsAleatoires(?)");
        $requete->bindparam(1, $cours, PDO::PARAM_INT,10);

        if (!empty($requete)) {
            $requete->execute();
        }
        $QuizAleatoire = $requete->fetchAll();

        if (!empty($QuizAleatoire))
        {
            $_SESSION['listeQuestionsAleatoires'] = $QuizAleatoire;
            echo 'Quiz généré.';
        }
    }
}





?>