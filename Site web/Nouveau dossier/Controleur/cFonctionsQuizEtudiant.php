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

/*
    Nom: genererReponsesCMU
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Cette fonction structure l'affichage des réponses de type choix multiples à réponse unique
*/
function genererReponsesCMU($idQuestion, $ordreReponse)
{
    //appeler une méthode qui récupère la liste des questions de la bd
    //si l'ordre des réponses est aléatoire, on shuffle les réponses
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

/*
    Nom: resetVarSessionScoreAffiche
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Crée et met à 0 les variable de session 'questionsRepondues' et 'bonnesReponses' s'il s'agit
                du premier affichage du score dans l'entête de question.
*/
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

/*
    Nom: resetVarSessionScoreAffiche
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Supprime les variables de session reliées aux questions et met à 0 celles de l'affichage
*/
function resetVarSessionQuiz()
{
    unset($_SESSION['listeQuestions'] );
    unset($_SESSION['listeReponses'] );
    unset($_SESSION['infoQuestion'] );
    unset($_SESSION['idQuestion'] );
    unset($_SESSION['listeQuestionRepondues']);
    unset($_SESSION['bienRepondu']);

    $_SESSION['questionsRepondues'] = 0;
    $_SESSION['bonnesReponses'] = 0;
}

/*
    Nom: gererReponse
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Traduit litéralement le true et false en 1 et 0.  On a besoin de int plus loin pour la
                 compilation du score.  En profite pour mettre à jour une variable de session via
                 la méthode  "updateReponseQuestionSession".
*/
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

/*
    Nom: updateReponseQuestionSession
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Met à jour la variable de session qui contient une liste de tous les résultats du quiz
                les résultats sont insérés en position 0 de la liste par un unshift.  Ainsi, les réponses sont aux mêmes
                positions que les idQuestions équivalentes dans la variable 'listeQuestionsRepondues'
*/
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

/*
    Nom: getNomCours
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Récupère le nom du cours à afficher dans l'entête de question.  Il s'agit du cours sélectionné dans
                le menu si on a cliqué sur un quiz aléatoire et du cours associé au quiz qui est cliqué et auquel
                l'étudiant est inscrit s'il s'agit d'un quiz formatif.
*/
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

/*
    Nom: getNomProfDuCoursDeLEtudiant
    Par: Isabelle Angrignon
    Date: octobre ou novembre 2014
    Description: Récupère le nom du prof de la variable listeCours
*/
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