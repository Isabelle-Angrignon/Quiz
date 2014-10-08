<?php
/**
 * Created by PhpStorm.
 * User: Isabelle
 * Date: 2014-10-06
 * Time: 15:15
 */



/*
    Nom: ListerQuizDansUl
    Par: Isabelle Angrignon copié de Simon Bouchard
    Date: 03/10/2014
    Description: Cette fonction génère autant de balise "li" qu'il y a de quiz à afficher
    Pour un type donnée, selon le cours et l'étudiant
*/
function ListerQuizDansUl($idUl, $idEtudiant, $idCours, $typeQuiz)
{
    $Donnee = ListerQuizEtudiantCours($idEtudiant, $idCours, $typeQuiz );
    foreach($Donnee as $Row)
    {
        GenererLi($idUl,$Row['titrequiz'], $Row['idQuiz']);
    }
}



?>