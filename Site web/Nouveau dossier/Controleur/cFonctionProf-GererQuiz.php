<?php
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