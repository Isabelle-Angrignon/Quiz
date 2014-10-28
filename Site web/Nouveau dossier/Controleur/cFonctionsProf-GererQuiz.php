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
function getQuestion($idQuestion) {
    return recupererElementsQuestion($idQuestion);
}

function getReponsesFromQuestion($idQuestion)
{
    if($idQuestion != null)
    {
        $tabIdReponses = array();
        $reponses = recupererReponsesAQuestion($idQuestion);

        foreach($reponses as $uneReponse)
        {
            creerInputReponse("radio","reponses", $uneReponse["idReponse"], $uneReponse["enonceReponse"], $uneReponse["reponseEstValide"]);
            array_push($tabIdReponses,$uneReponse["idReponse"]);
        }
        $_SESSION["tabIdReponses"] = $tabIdReponses;
    }
}

function afficherTypesQuestions()
{
    $Types = listerTypesQuestions();

    foreach($Types as $unType)
    {
        creerInputGenerique("radio","typesQuestion", $unType["typeQuestion"], str_replace('_', ' ', $unType["typeQuestion"]));
    }
}

function afficherTypesQuiz()
{
    $Types = listerTypesQuiz();

    foreach($Types as $unType)
    {
        creerInputGenerique("checkbox","typesQuestion", $unType["typeQuiz"], $unType["typeQuiz"]);
    }
}

function prendreTypeQuizAssocie($idQuestion)
{
    $Types = listerTypesQuizAssocie($idQuestion);
    return $Types;
}

function creerInputReponse($typeInput, $nomDuGroupe, $valeur, $textAffiche, $isChecked)
{
    $isChecked? $checked = "checked":$checked="";
    echo "<li><input type='".$typeInput."' name=".$nomDuGroupe." value=".$valeur." ".$checked."><div class='reponsesQuestion' contenteditable='true'>".$textAffiche."</div></li>";
}

function creerInputGenerique($typeInput, $nomDuGroupe,$valeur,$textAffiche)
{
    echo "<li><input type='".$typeInput."' name=".$nomDuGroupe." value=".$valeur.">".$textAffiche."</li>";
}

// ajouterUneQuestion
// Par: Mathieu Dumoulin
// Date: 15/10/2014
// Intrants: N.B. Toutes les variables commençants par tableau dans cette fonction représente un tableau PHP sous forme de couple clé=>valeur.
//           $tableauDeQuestion      = Un tableau comportant tous les attributs à modifier dans la table question.
//           $tableauReponses        = Un tableau deux dimension comportant toutes les réponses de la question à ajouter (une par rangée).
//           $tableauCours           = Un tableau comportant la liste de tous les identifiants de cours dont la question est associée
//           $tableauTypeQuizAssocie = Un tableau comportant le/les identifiant(s) du/des type(s) de quiz associé(s) à la question
// Description: Cette fonction ajoute une question ainsi que toutes ses attributs dans la BD, le tout enveloppé dans une transaction qui cancelle
//              les ajouts s'il y a des erreures de déclanchées.
function ajouterUneQuestion($tableauDeQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie)
{
    try
    {
        $bdd = connecterProf();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        set_error_handler('useless_error_handler');
        $bdd->beginTransaction();


        isset($tableauTypeQuizAssocie)? $estDiponible = 1: $estDiponible = 0;
        // Ajouter la question dans la base de données
        $idQuestion = ajouterQuestion($bdd, $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
                    /*$tableauDeQuestion['difficulte']*/ "1- Facile", /*$tableauDeQuestion['ordreReponsesAleatoire']*/ 0,
                    $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], /*$tableauDeQuestion['referenceWeb']*/ null, $estDiponible);

        // Ajouter les réponses de cette question dans la base de données
        $positionReponse = 0;
        foreach($tableauReponses['reponses'] as $reponse)
        {
            $estBon = convertEstBonneReponseToTINYINT($reponse['estBonneReponse']);
            ajouterReponse($bdd, $reponse['enonce'], "", $idQuestion[0], $estBon, ++$positionReponse);
        }

        $positionCours = 0;
        // Associer la question à un/plusieurs cours
        foreach($tableauCours['cours'] as $Cours)
        {
            associerQuestionACours($bdd, $idQuestion[0], $Cours['idCours']);
        }

        // Associer la question à un/des type(s) de quiz
        if(isset($tableauTypeQuizAssocie))
        {
            foreach($tableauTypeQuizAssocie['typeQuizAss'] as $typeQuiz)
            {
                associerTypeQuizQuestion($bdd, $idQuestion[0], $typeQuiz['id']);
            }
        }


        $bdd->commit();
    }
    //catch(PDOException $e){}
    catch(ErrorException $e)
    {
        try
        {
            //on annule la transation
            $bdd->rollback();

            //on affiche un message d'erreur ainsi que les erreurs
            echo $e->getMessage();
        }
        catch (PDOException $e){echo "Erreur dans le rollback";}
    }

    restore_error_handler();
    unset($bdd);
}

function modifierUneQuestion($tableauDeQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie)
{
    try
    {
        $bdd = connecterProf();
        set_error_handler('useless_error_handler');
        $bdd->beginTransaction();

        // Modifier la question dans la base de données
        isset($tableauTypeQuizAssocie)? $estDiponible = 1: $estDiponible = 0;
        modifierQuestion($bdd, $tableauDeQuestion['idQuestion'], $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
           /*$tableauDeQuestion['difficulte']*/ "1- Facile", /*$tableauDeQuestion['ordreReponsesAleatoire']*/ 0,
           $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], /*$tableauDeQuestion['referenceWeb']*/ null, $estDiponible);

        // Ajouter les réponses de cette question dans la base de données
        modifierReponses($bdd, $tableauReponses, $tableauDeQuestion['idQuestion']);


        // Associer la question à un/plusieurs cours
        dissocierQuestionACours($bdd, $tableauDeQuestion['idQuestion']);
        foreach($tableauCours['cours'] as $Cours)
        {
            associerQuestionACours($bdd, $tableauDeQuestion['idQuestion'], $Cours['idCours']);
        }

        // Associer la question à un/des type(s) de quiz
        dissocierTypeQuizQuestion($bdd, $tableauDeQuestion['idQuestion']);
        foreach($tableauTypeQuizAssocie['typeQuizAss'] as $typeQuiz)
        {
            associerTypeQuizQuestion($bdd, $tableauDeQuestion['idQuestion'], $typeQuiz['id']);
        }

        $bdd->commit();
    }
    catch(ErrorException $e)
    {
        try
        {
            //on annule la transation
            $bdd->rollback();

            echo $e->getMessage();
        }
        catch (PDOException $e){echo "Erreur dans le rollback";}
    }
    restore_error_handler();
    unset($bdd);

}

function convertEstBonneReponseToTINYINT($estBonneReponse)
{
    return $estBonneReponse=='true'?1:0;
}

function modifierReponses($bdd, $tableauReponses, $identifiantQuestion)
{
    // Reprendre les anciennes réponses
    if(isset($_SESSION["tabIdReponses"]))
    {
        $tabIdAnciennesReponses = $_SESSION["tabIdReponses"];
    }
    else
    {
        $tabIdAnciennesReponses = array();
    }

    // Si on encode pas notre tableauReponses, PHP ne le reconnait pas comme étant un vrai JSON.
    $tableauNouvelleReponses = json_decode(json_encode($tableauReponses));

    // Je dois garder une variable qui contient la grandeur du tableau initial car unset(array[index]) de change pas l'index des éléments qui suivent le unset mais change le size du tableau
    $nbAncienneReponses = count($tabIdAnciennesReponses);
    $nbNouvelleReponses = count($tableauNouvelleReponses->reponses);

    $positionReponse = 0;
    for($x = 0; $x < $nbNouvelleReponses; ++$x)
    {
        $action = "";
        for($i = 0; $i < $nbAncienneReponses && $action == ""; ++$i)
        {
            if(isset($tabIdAnciennesReponses[$i]))
            {
                if($tabIdAnciennesReponses[$i] == $tableauNouvelleReponses->reponses[$x]->idReponse)
                {
                    $action = "Modifier";
                    unset($tabIdAnciennesReponses[$i]);
                }
            }

        }
        if($action == "Modifier")
        {
            $idReponse = $tableauNouvelleReponses->reponses[$x]->idReponse;
            $enonce = $tableauNouvelleReponses->reponses[$x]->enonce;
            $positionReponse = $tableauNouvelleReponses->reponses[$x]->positionReponse;
            // Dans la base de donnée, estBonneReponse représente un TINYINT donc on doit le transformer en TINYINT.
            $estBon = convertEstBonneReponseToTINYINT($tableauNouvelleReponses->reponses[$x]->estBonneReponse);

            modifierReponse($bdd,$idReponse, $enonce,"", $estBon, $positionReponse);
            unset($tableauNouvelleReponses->reponses[$x]);
        }
    }
    // Ajouter les nouvelles réponses dans la bd
    foreach($tableauNouvelleReponses->reponses as $reponse)
    {
        $enonce = $reponse->enonce;
        $positionReponse = $reponse->positionReponse;
        $idQuestion =  $identifiantQuestion;
        // Dans la base de donnée, estBonneReponse représente un TINYINT donc on doit le transformer en TINYINT.
        $estBon = convertEstBonneReponseToTINYINT($reponse->estBonneReponse);

        ajouterReponse($bdd, $enonce, "", $idQuestion, $estBon, $positionReponse);
    }

    foreach($tabIdAnciennesReponses as $idAncienneReponse)
    {
        supprimerReponse($bdd, $idAncienneReponse);
    }
}


function useless_error_handler($no, $str, $file, $line){
    switch($no){
        // Erreur fatale
        case E_USER_ERROR:
            echo "Fatale";
            break;

        // Avertissement
        case E_USER_WARNING:
            echo "Warning";
            break;

        // Note
        case E_USER_NOTICE:
            echo "Notice";
            break;

        // Erreur générée par PHP
        default:
            echo "Message : ". $str . " ---------- Ligne: ". $line . " ------------" . $file;
            break;
    }
}


?>

