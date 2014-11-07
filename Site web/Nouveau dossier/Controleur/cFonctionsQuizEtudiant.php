<?php


/*
    Nom: ListerQuizDansUl
    Par: Isabelle Angrignon copié de Simon Bouchard
    Date: 03/10/2014
    Description: Cette fonction génère autant de balise "li" qu'il y a de quiz à afficher
    Pour un type donnée, selon le cours et l'étudiant
*/


function ListerQuizDansUl($idUl, $idEtudiant, $idCours, $typeQuiz)
{
    if ($idCours == 0)
    {
        $Donnee = ListerQuizEtudiant($idEtudiant, $typeQuiz );
        foreach($Donnee as $Row)
        {
            GenererLiSelect($idUl,$Row['titreQuiz'], $Row['idQuiz']);
        }
    }
    else
    {
        $Donnee = ListerQuizEtudiantCours($idEtudiant, $idCours, $typeQuiz );
        foreach($Donnee as $Row)
        {
            GenererLiSelect($idUl,$Row['titreQuiz'], $Row['idQuiz']);
        }
    }

}

/*
    Nom: genererChoixDeReponses
    Par: Isabelle Angrignon
    Date: 08/10/2014
    Description: Cette fonction appelle une seconde méthode pour générer l'affichage des réponses en fonction du type de question
*/
function genererChoixDeReponses($idQuestion, $typeQuestion, $ordreReponse)
{
    switch ($typeQuestion)
    {
        case 'VRAI_FAUX':
            genererReponsesVF($idQuestion);
            break;
        case 'CHOIX_MULTI_UNIQUE':
            genererReponsesCMU($idQuestion, $ordreReponse);
            break;
    }
}

/*
    Nom: genererReponsesVF
    Par: Isabelle Angrignon
    Date: 08/10/2014
    Description: Cette fonction structure l'affichage des réponses de type vrai ou faux.
*/

function genererReponsesVF($idQuestion)
{
    $listeReponses = recupererReponsesVraiFaux($idQuestion);

    if (!empty($listeReponses))
    {
        $_SESSION['listeReponses'] = $listeReponses;
    }
    else
    {
        unset($_SESSION['listeReponses']);
    }
    //générer deux li, un vrai et un faux
    GenererLiSelect('UlChoixReponse', 'Vrai', '1' );
    GenererLiSelect('UlChoixReponse', 'Faux', '0' );
}
function genererReponsesCMU($idQuestion, $ordreReponse)
{
    //appeler une méthode qui récupère la liste des questions de la bd
    //si l'ordre des  $listeReponses = rréponses est aléatoire, shuffle les réponses
    $listeReponses = recupererReponsesAQuestion($idQuestion);

    if($ordreReponse == 1)
    {
        shuffle($listeReponses);
    }

    if (!empty($listeReponses))
    {
        $_SESSION['listeReponses'] = $listeReponses;

        foreach ($listeReponses as $Row)
        {
            GenererLiSelect('UlChoixReponse', $Row['enonceReponse'], $Row['idReponse']);
        }
    }
    else
    {
        unset($_SESSION['listeReponses']);
    }
}


function resetVarSessionQuiz()
{
    unset($_SESSION['listeQuestions'] );
    unset($_SESSION['listeReponses'] );
    unset($_SESSION['infoQuestion'] );
    unset($_SESSION['idQuestion'] );
    unset($_SESSION['listeQuestionRepondues']);
    unset($_SESSION['bienRepondu']);

    //Pour affichage html dans le pop-up de questions
    $_SESSION['questionsRepondues'] = 0;
    $_SESSION['bonnesReponses'] = 0;
}

function gererReponse($estBonneReponse)
{
    if($estBonneReponse)
    {
        echo "1";
        updateReponseQuestionSession(1);
    }
    else
    {
        echo "0";
        updateReponseQuestionSession(0);
    }
}

function updateReponseQuestionSession($estBonneReponse)
{
    $reponse['resultat'] = $estBonneReponse;
    if (!isset($_SESSION['bienRepondu']))
    {
        $_SESSION['bienRepondu'][0] = $estBonneReponse;
    }
    else
    {
        array_unshift($_SESSION['bienRepondu'] ,$estBonneReponse );
    }


}

function getNomCours()
{
    $nomCours = "Nom du cours ?";
    foreach($_SESSION['listeCours'] as $cours)
    {
        if ($cours['idCours'] == $_SESSION['idCours'])
        {
            $nomCours = $cours['codeCours'] . ' ' . $cours['nomCours'];
        }
    }
    return $nomCours;
}

function getNomProfDuCoursDeLEtudiant()
{
    $nomProf = "Nom du prof ?";
    foreach($_SESSION['listeCours'] as $cours)
    {
        if ($cours['idCours'] == $_SESSION['idCours'])
        {
            $nomProf = $cours['prenom'] . ' ' . $cours['nom'];
        }
    }
    return $nomProf;
}


?>