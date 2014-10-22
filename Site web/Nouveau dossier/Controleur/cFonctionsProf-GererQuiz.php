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
        $reponses = recupererReponsesAQuestion($idQuestion);

        foreach($reponses as $uneReponse)
        {
            creerCheckBoxReponse("reponses", $uneReponse["idReponse"], $uneReponse["enonceReponse"], $uneReponse["reponseEstValide"]);
        }
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

function creerCheckBoxReponse($nomDuGroupe, $valeur, $textAffiche, $isChecked)
{
    $isChecked? $checked = "checked":$checked="";
    echo "<li><input type='checkbox' name=".$nomDuGroupe." value=".$valeur." ".$checked."><div class='reponsesQuestion' contenteditable='true'>".$textAffiche."</div></li>";
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


        // Ajouter la question dans la base de données
        $idQuestion = ajouterQuestion($bdd, $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
                    /*$tableauDeQuestion['difficulte']*/ "1- Facile", /*$tableauDeQuestion['ordreReponsesAleatoire']*/ 0,
                    $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], /*$tableauDeQuestion['referenceWeb']*/ null);

        // Ajouter les réponses de cette question dans la base de données
        $positionReponse = 0;
        foreach($tableauReponses['reponses'] as $reponse)
        {
            $estBon = 0;
            if($reponse['estBonneReponse'] == 'true')
            {
                $estBon = 1;
            }
            ajouterReponse($bdd, $reponse['enonce'], "", $idQuestion[0], $estBon, ++$positionReponse);
        }
        $positionCours = 0;
        // Associer la question à un/plusieurs cours
        foreach($tableauCours['cours'] as $Cours)
        {
            associerQuestionACours($bdd, $idQuestion[0], $Cours['idCours']);
        }

        // Associer la question à un/des type(s) de quiz
        foreach($tableauTypeQuizAssocie['typeQuizAss'] as $typeQuiz)
        {
            associerTypeQuizQuestion($bdd, 200, $typeQuiz['id']);
        }

        echo json_encode(array("idNouvelleQuestion" => $idQuestion[0], "IntroErreur" => "", "Erreur" => ""));
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
            echo json_encode(array("idNouvelleQuestion" => "", "IntroErreur" => "Tout ne s'est pas bien passé, voir les erreurs ci-dessous", "Erreur" => $e->getMessage()));
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


        // Ajouter la question dans la base de données
        $idQuestion = modifierQuestion($bdd, $tableauDeQuestion['idQuestion'], $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
            /*$tableauDeQuestion['difficulte']*/ "1- Facile", /*$tableauDeQuestion['ordreReponsesAleatoire']*/ 0,
            $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], /*$tableauDeQuestion['referenceWeb']*/ null);

        /*// Ajouter les réponses de cette question dans la base de données
        $positionReponse = 0;
        foreach($tableauReponses['reponses'] as $reponse)
        {
            $estBon = 0;
            if($reponse['estBonneReponse'] == 'true')
            {
                $estBon = 1;
            }
            ajouterReponse($bdd, $reponse['enonce'], null, $idQuestion, $estBon, ++$positionReponse);
        }

        // Associer la question à un/plusieurs cours
        foreach($tableauCours['cours'] as $Cours)
        {
            associerQuestionACours($bdd, $idQuestion[0], $Cours['idCours']);
        }

        // Associer la question à un/des type(s) de quiz

        foreach($tableauTypeQuizAssocie['typeQuizAss'] as $typeQuiz)
        {
            associerTypeQuizQuestion($bdd, $idQuestion[0], $typeQuiz['id']);
        }
        echo $idQuestion[0];*/
        $bdd->commit();
    }
    catch(ErrorException $e)
    {
        try
        {
            //on annule la transation
            $bdd->rollback();

            //on affiche un message d'erreur ainsi que les erreurs
            echo 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />';
            echo 'Erreur : '.$e->getMessage().'<br />';
            echo 'N° : '.$e->getCode();
        }
        catch (PDOException $e){echo "Erreur dans le rollback";}
    }
    restore_error_handler();
    unset($bdd);

}

function useless_error_handler($no, $str, $file, $line){
    switch($no){
        // Erreur fatale
        case E_USER_ERROR:
            break;

        // Avertissement
        case E_USER_WARNING:
            break;

        // Note
        case E_USER_NOTICE:
            break;

        // Erreur générée par PHP
        default:
            break;
    }
}


?>

