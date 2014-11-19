<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  cFonctionsQuizEtudiant.php
//  Fait par : Isabelle Angrignon
//  Commenté le : 18/11/2014
//
//  Contenu : Définitions de différentes fonctions "contrôleur" appelées par des pages php.  Elles sont toutes reliées à la page
//        "Etudiant-Accueil.php", son divDynamique "dynamique-RepondreQuestion.php" ou toute autre page découlant de celles-ci.
//         Elles sont donc toutes liées à la génération de listes de quiz pour un étudiant, ou la génération d'un quiz
//         et la gestion de ses réponses.
//
////////////////////////////////////////////////////////////////////////////////////////////////////


/*
    Nom: ListerQuizDansUl
    Par: Isabelle Angrignon copié de Simon Bouchard
    Date: 03/10/2014
    Description: Cette fonction génère autant de balise "li" qu'il y a de quiz à afficher
    Pour un type donnée, selon le cours et l'étudiant
*/
function ListerQuizDansUl($idUl, $idEtudiant, $idCours, $typeQuiz, $classe)
{
    if ($idCours == 0)
    {
        $Donnee = ListerQuizEtudiant($idEtudiant, $typeQuiz );
        foreach($Donnee as $Row)
        {
            GenererLiSelectQuiz($idUl, $Row['titreQuiz'], $Row['idQuiz'],
                $Row['prenom']." ". $Row['nom'],
                $classe, $Row['idUsager_Proprietaire'] );
        }
    }
    else
    {
        $Donnee = ListerQuizEtudiantCours($idEtudiant, $idCours, $typeQuiz );
        foreach($Donnee as $Row)
        {
            GenererLiSelectQuiz($idUl,$Row['titreQuiz'], $Row['idQuiz'],
                $Row['prenom']." ". $Row['nom'],
                $classe, $Row['idUsager_Proprietaire']);
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
    GenererLiSelectReponse('UlChoixReponse', 'Vrai', '1' );
    GenererLiSelectReponse('UlChoixReponse', 'Faux', '0' );
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
            GenererLiSelectReponse('UlChoixReponse', $Row['enonceReponse'], $Row['idReponse']);
        }
    }
    else
    {
        unset($_SESSION['listeReponses']);
    }
}


function resetVarSessionScoreAffiche()
{
    if(!isset($_SESSION['questionsRepondues']))
    {
        $_SESSION['questionsRepondues'] = 0;
    }
    if(!isset($_SESSION['bonnesReponses']))
    {
        $_SESSION['bonnesReponses'] = 0;
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

//Traduit litéralement le true et false en 1 et 0.  On a besoin de int plus loin pour la compilation du score
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
    if($_SESSION['typeQuiz'] == "ALEATOIRE")
    {
        foreach($_SESSION['listeCours'] as $cours)
        {
            if ($cours['idCours'] == $_SESSION['idCours'])
            {
                $nomCours = $cours['codeCours'] . ' ' . $cours['nomCours'];
            }
        }
    }
    else
    {
        $cours = recupererCoursQuizEtudiant($_SESSION['idQuiz'], $_SESSION['idUsager']);
        $nomCours = $cours[0]['codeCours'] . ' ' . $cours[0]['nomCours'];
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