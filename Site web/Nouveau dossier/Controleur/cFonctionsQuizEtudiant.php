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


/*
    Nom: genererChoixDeReponses
    Par: Isabelle Angrignon
    Date: 08/10/2014
    Description: Cette fonction appelle une seconde méthode pour générer l'affichage des réponses en fonction du type de question
*/
function genererChoixDeReponses($idQuestion, $typeQuestion)
{
    switch ($typeQuestion)
    {
        case 'VRAI_FAUX':
            genererReponsesVF($idQuestion);
            echo "Vrai-faux";
            break;
        case 'CHOIX_MULTI_UNIQUE';
            genererReponsesCMU($idQuestion);
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
    //générer deux li, un vrai et un faux
    GenererLi('UlChoixReponse', 'Vrai', 'V' );
    GenererLi('UlChoixReponse', 'Faux', 'F' );
}
function genererReponsesCMU($idQuestion)
{
    //appeler une méthode qui récupère la liste des questions de la bd
    //si l'ordre des réponses est aléatoire, shuffle les réponses
    //mettre toutes les réponses dans des li différents
   //   genre    ListerQuizDansUl("UlQuizFormatif", $_SESSION["idUsager"], "get id cours dans ddl selected", "FORMATIF")
}


?>