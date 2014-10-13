<?php
// Nom: remplirListeQuestions
// Par: Mathieu Dumoulin
// Intrants: $idCours = identifiant du cours en question.
//           $idProprietaire = identifiant du professeur en question
//           $triage = le type de triage à effectuer
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions() et envoie la réponse à la fonction javascript traiterJSONQuestions
function remplirListeQuestions($idCours, $idProprietaire, $triage = 'default')
{
    if($triage == 'default')
    {
        $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire);
    }
    echo "<script>traiterJSONQuestions(" . $resultatTriage .");</script>";
}


// Nom: getEnnonceDeQuestion
// Par: Mathieu Dumoulin
// Date: 13/10/2014
// Description: Cette fonction
function getQuestion($idQuestion) {
    return recupererElementsQuestion($idQuestion);
}

?>

