<?php
// Nom: remplirListeQuestions
// Par: Mathieu Dumoulin, modifié par Isabelle ANgrignon, ajouté filtreEnoncé
// Intrants: $idCours = identifiant du cours en question.
//           $idProprietaire = identifiant du professeur en question
//           $triage = le type de triage à effectuer
//           $filtreEnonce = le filtre à appliquer pour l'énoncé
//           $filtreId = le filtre à appliquer pour l'identifiant de question
// Extrants: Le résultat de la procédure, sous forme de JSON
// Description: Cette fonction communique à la BD à l'aide de la fonction listerQuestions() et envoie la réponse à la fonction javascript traiterJSONQuestions
function remplirListeQuestions($idCours, $idProprietaire, $triage = 'default', $filtreEnonce = "", $filtreId = 0)
{
    if($triage == 'default')
    {
        $resultatTriage = trieParDefaultQuestions($idCours, $idProprietaire, $filtreEnonce, $filtreId);
    }
    echo "<script>traiterJSONQuestions(" . $resultatTriage .", 'UlQuestion');</script>";
}


function remplirListeQuiz($idCours, $idProprietaire)
{
    $listeQuiz = listerQuizSelonCoursProprietaire($idCours, $idProprietaire);
    echo "<script>transformerJSONQuizEnLi(" . $listeQuiz .");</script>";
}


// Nom: getEnnonceDeQuestion
// Par: Mathieu Dumoulin
// Date: 13/10/2014
function getQuestion($idQuestion) {
    return recupererElementsQuestion($idQuestion);
}

// getReponsesFromQuestion
// Par Mathieu Dumoulin
// Description : Cette fonction créé des réponses selon son type de question dans l'interface dynamique-GererQuestion.php
function getReponsesFromQuestion($idQuestion, $typeQuestion)
{
    if($idQuestion != null)
    {
        $tabIdReponses = array();
        if($typeQuestion == "VRAI_FAUX")
        {
            // Reprend dans la base de données les réponses vrai/faux et laquelle qui est valide
            $reponse = afficherQuestionVraiFaux($idQuestion);
            // Créé une réponse dans l'interface correspondant à la réponse Vrai de la base de données
            creerInputReponse("radio","reponses", 1, "Vrai", $reponse["reponseEstVrai"]);
            // fauxEstVrai = l'inverse de reponseEstVrai sous forme de TINYINT (format dans laquelle cette valeur est stockée dans la base de données
            $reponse["reponseEstVrai"] == 1? $fauxEstVrai = 0: $fauxEstVrai = 1;
            // Créé une réponse dans l'interface correspondant à la réponse Faux de la base de données
            creerInputReponse("radio","reponses", 0, "Faux", $fauxEstVrai);
            // Disable la modification/ajout/suppression de réponse
            echo "<script>enleverModificationReponses()</script>";
        }
        else
        {
            // Reprend dans la base de données les réponses de cette question
            $reponses = recupererReponsesAQuestion($idQuestion);
            foreach($reponses as $uneReponse)
            {
                creerInputReponse("radio","reponses", $uneReponse["idReponse"], $uneReponse["enonceReponse"], $uneReponse["reponseEstValide"]);
                // Création d'un tableau qui va être ajouter à la session
                array_push($tabIdReponses,$uneReponse["idReponse"]);
            }
        }
        // J'ajoute ici mes réponses pour que, lors de la modification d'une question, je puisse comparer mes réponses initiales (ce tableau)
        // aux nouvelles réponses et, du même coup, connaître quelles réponses ont été modifié, ajouter ou supprimer.
        $_SESSION["tabIdReponses"] = $tabIdReponses;
    }
}

// afficherTypesQuestions
// Par Mathieu Dumoulin
// Description : Cette fonction reprend les types de questions de la base de données
//               et les affiches à l'emplacement de l'appel de cette fonction (echo)
function afficherTypesQuestions()
{
    $Types = listerTypesQuestions();

    foreach($Types as $unType)
    {
        creerInputGenerique("radio","typesQuestion", $unType["typeQuestion"], str_replace('_', ' ', $unType["typeQuestion"]));
    }
}

// afficherTypesQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction prend les types de quiz dans la base de données
//               et les affiches à l'eplacement de l'appel de cette fonction (echo)
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

// creerInputReponse
// Par Mathieu Dumoulin
// Intrants : $typeInput = correspond à l'attribut <input type="..."
//            $nomDuGroupe = correspond à l'attribut <input name="..."
//            $valeur = correspond à l'attribut <input value="..."
//            $textAffiche = correspond au texte contenu de base dans le TextArea
//            $isChecked = Si c'est une bonne réponse ou non
// Description : Cette fonction echo un Li qui contient un input ainsi qu'un textArea pour contenir une réponse.
function creerInputReponse($typeInput, $nomDuGroupe, $valeur, $textAffiche, $isChecked)
{
    $isChecked? $checked = "checked":$checked="";
    echo "<li><input type='".$typeInput."' name=".$nomDuGroupe." value=".$valeur." ".$checked."><textarea class='reponsesQuestion' rows='1' placeholder='Entrer une réponse ici...'>".$textAffiche."</textarea></li>";
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
        // Lève le mode d'exception. Ça me permet de capter les exceptions PDO pour me permettre de canceller ma transaction
        // s'il y a des problèmes lors de l'ajout dans la BD.
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Un error handler qui ne fait rien. Pour ne pas que l'usager puisse capter des erreurs "non contrôlés"
        set_error_handler('useless_error_handler');
        // Début de la transaction
        $bdd->beginTransaction();

        isset($tableauTypeQuizAssocie)? $estDiponible = 1: $estDiponible = 0;
        $ordreReponsesTINYINT = convertStringBooleanToTINYINT($tableauDeQuestion['ordreReponsesAleatoire']);

        // Ajouter la question dans la base de données
        $idQuestion = ajouterQuestion($bdd, $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
                    /*$tableauDeQuestion['difficulte']*/ "1- Facile",$ordreReponsesTINYINT ,
                    $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], $tableauDeQuestion['lienWeb'], $estDiponible);


        // Ajouter les réponses de cette question dans la base de données
        if($typeQuestion != "VRAI_FAUX")
        {
            $positionReponse = 0;
            foreach($tableauReponses['reponses'] as $reponse)
            {
                $estBon = convertStringBooleanToTINYINT($reponse['estBonneReponse']);
                ajouterReponse($bdd, $reponse['enonce'], "", $idQuestion[0], $estBon, ++$positionReponse);
            }
        }
        else
        {
            $estVrai = 0;
            foreach($tableauReponses['reponses'] as $reponse)
            {
                if($reponse['idReponse'] == 1 && $reponse["estBonneReponse"] == true)
                {
                    $estVrai = 1;
                }
            }

            ajouterLienQuestionsVraiFaux($bdd, $idQuestion[0], $estVrai);
        }

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

        // Finalise la transaction (le commit dans la bd)
        $bdd->commit();
    }
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

// modifierUneQuestion
// Par: Mathieu Dumoulin
// Intrants: N.B. Toutes les variables commençants par tableau dans cette fonction représente un tableau PHP sous forme de couple clé=>valeur.
//           $tableauDeQuestion      = Un tableau comportant tous les attributs à modifier dans la table question.
//           $tableauReponses        = Un tableau deux dimension comportant toutes les réponses de la question à modifier (une par rangée).
//           $tableauCours           = Un tableau comportant la liste de tous les identifiants de cours dont la question est associée
//           $tableauTypeQuizAssocie = Un tableau comportant le/les identifiant(s) du/des type(s) de quiz associé(s) à la question
// Description: Cette fonction modifie une question ainsi que toutes ses attributs dans la BD, le tout enveloppé dans une transaction qui cancelle
//              les modifications s'il y a des erreures de déclanchées.
function modifierUneQuestion($tableauDeQuestion, $tableauReponses, $tableauCours, $typeQuestion, $tableauTypeQuizAssocie)
{
    try
    {
        $bdd = connecterProf();
        // Un error handler qui ne fait rien. Pour ne pas que l'usager puisse capter des erreurs "non contrôlés"
        set_error_handler('useless_error_handler');
        $bdd->beginTransaction();

        // Modifier la question dans la base de données
        isset($tableauTypeQuizAssocie)? $estDiponible = 1: $estDiponible = 0;
        $ordreReponsesTINYINT = convertStringBooleanToTINYINT($tableauDeQuestion['ordreReponsesAleatoire']);

        modifierQuestion($bdd, $tableauDeQuestion['idQuestion'], $tableauDeQuestion['enonceQuestion'], /*$tableauDeQuestion['imageQuestion']*/ null,
           /*$tableauDeQuestion['difficulte']*/ "1- Facile", $ordreReponsesTINYINT,
           $typeQuestion, $tableauDeQuestion['idUsager_Proprietaire'], $tableauDeQuestion['lienWeb'], $estDiponible);

        // Ajouter les réponses de cette question dans la base de données
        modifierReponses($bdd, $tableauReponses, $tableauDeQuestion['idQuestion'], $typeQuestion);

        // Je supprime la question de la table Liaison Vrai/Faux
        supprimerLienQuestionVraiFaux($bdd, $tableauDeQuestion['idQuestion']);

        if($typeQuestion == "VRAI_FAUX")
        {
            $estVrai = 0;
            foreach($tableauReponses['reponses'] as $reponse)
            {
                if($reponse['idReponse'] == 1 && $reponse["estBonneReponse"] == "true")
                {
                    $estVrai = 1;
                }
            }

            ajouterLienQuestionsVraiFaux($bdd, $tableauDeQuestion['idQuestion'], $estVrai);
        }


        // Associer la question à un/plusieurs cours
        dissocierQuestionACours($bdd, $tableauDeQuestion['idQuestion']);
        foreach($tableauCours['cours'] as $Cours)
        {
            associerQuestionACours($bdd, $tableauDeQuestion['idQuestion'], $Cours['idCours']);
        }

        // Associer la question à un/des type(s) de quiz
        dissocierTypeQuizQuestion($bdd, $tableauDeQuestion['idQuestion']);
        if(isset($tableauTypeQuizAssocie))
        {
            foreach($tableauTypeQuizAssocie['typeQuizAss'] as $typeQuiz)
            {
                associerTypeQuizQuestion($bdd, $tableauDeQuestion['idQuestion'], $typeQuiz['id']);
            }
        }

        $bdd->commit();
    }
    catch(ErrorException $e)
    {
        try
        {
            //on annule la transation
            $bdd->rollback();
            // on envoie le message d'erreur
            echo $e->getMessage();
        }
        catch (PDOException $e){echo "Erreur dans le rollback";}
    }
    restore_error_handler();
    unset($bdd);

}

// modifierReponses
// Par Mathieu Dumoulin
// Intrants : $bdd = la connexion à la base de données
//            $tableauReponses = Un tableau deux dimension comportant toutes les réponses de la question à modifier (une par rangée).
//            $identifiantQuestion = l'id de la question qui possède ces réponses
//            $typeQuestion = le type de la question qui possède ces réponses
// Description : Cette fonction modifie les réponses d'une question en comparant les anciennes questions aux nouvelles question
//               - Si la question est présente dans les deux tableaux, modifie la dans la bd.
//               - Si la question n'est pas présente dans le tableau de nouvelles réponses mais qu'elle est présente dans le tableau des anciennes réponses, supprime la.
//               - Si la question n'est pas présente dans le tableau d'anciennes réponses mais qu'elle est présente dans le tableau des nouvelles réponses, ajoute la.
function modifierReponses($bdd, $tableauReponses, $identifiantQuestion, $typeQuestion)
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
    if($typeQuestion != "Vrai_Faux")
    {
        // Si on encode pas notre tableauReponses, PHP ne le reconnait pas comme étant un vrai JSON.
        $tableauNouvelleReponses = json_decode(json_encode($tableauReponses));

        // Je dois garder une variable qui contient la grandeur du tableau initial car unset(array[index]) ne change pas l'index
        // des éléments qui suivent le unset mais change le size du tableau
        $nbAncienneReponses = count($tabIdAnciennesReponses);
        $nbNouvelleReponses = count($tableauNouvelleReponses->reponses);

        $positionReponse = 0;
        for($x = 0; $x < $nbNouvelleReponses; ++$x)
        {
            $action = "";
            // Pour vérifier si les anciennes réponses sont toujours présentes dans les nouvelles réponses
            for($i = 0; $i < $nbAncienneReponses && $action == ""; ++$i)
            {
                if(isset($tabIdAnciennesReponses[$i]))
                {
                    if($tabIdAnciennesReponses[$i] == $tableauNouvelleReponses->reponses[$x]->idReponse)
                    {
                        $action = "Modifier";   // Retire les anciennes réponses du tableau
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
                $estBon = convertStringBooleanToTINYINT($tableauNouvelleReponses->reponses[$x]->estBonneReponse);

                modifierReponse($bdd,$idReponse, $enonce,"", $estBon, $positionReponse);    // Modifie les anciennes réponses par rapport à la nouvelle
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
            $estBon = convertStringBooleanToTINYINT($reponse->estBonneReponse);

            ajouterReponse($bdd, $enonce, "", $idQuestion, $estBon, $positionReponse);
        }
    }

    // Parcours les anciennes réponses qui ne sont pas dans le tableau de nouvelles réponses et supprime les de la BD.
    foreach($tabIdAnciennesReponses as $idAncienneReponse)
    {
        supprimerReponse($bdd, $idAncienneReponse);
    }
}


// ajouterUnQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction ajoute un quiz dans la base de données à l'aide d'une transaction qui annule l'ajout dès
//               qu'il y a un erreur qui occur.
function ajouterUnQuiz($titreQuiz, $ordreEstAleatoire, $idProprietaire, $estDisponible, $jsonCours)
{
    try
    {
        $bdd = connecterProf();
        // Un error handler qui ne fait rien. Pour ne pas que l'usager puisse capter des erreurs "non contrôlés"
        set_error_handler('useless_error_handler');
        $bdd->beginTransaction();

        $ordreEstAleatoire = convertStringBooleanToTINYINT($ordreEstAleatoire);
        $estDisponible = convertStringBooleanToTINYINT($estDisponible);

        $idNouveauQuiz = ajouterQuiz($bdd, $titreQuiz, $ordreEstAleatoire, $idProprietaire, $estDisponible);

        // Associer la question à un/plusieurs cours
        foreach($jsonCours['cours'] as $Cours)
        {
            associerQuizCours($bdd, $idNouveauQuiz, $Cours['idCours']);
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

// modifierUnQuiz
// Par Mathieu Dumoulin
// Description : Cette fonction modifie un quiz dans la base de données à l'aide d'une transaction qui annule la modification dès
//               qu'il y a un erreur qui occur.
function modifierUnQuiz($idQuiz ,$titreQuiz, $ordreEstAleatoire, $idProprietaire, $estDisponible, $jsonCours)
{
    try
    {
        $bdd = connecterProf();
        // Un error handler qui ne fait rien. Pour ne pas que l'usager puisse capter des erreurs "non contrôlés"
        set_error_handler('useless_error_handler');
        $bdd->beginTransaction();

        $ordreEstAleatoire = convertStringBooleanToTINYINT($ordreEstAleatoire);
        $estDisponible = convertStringBooleanToTINYINT($estDisponible);

        modifierQuiz($bdd, $idQuiz, $titreQuiz, $ordreEstAleatoire, $idProprietaire, $estDisponible);

        // Supprimer les liens du quiz avec les cours
        supprimerLienQuizCours($bdd, $idQuiz);
        // Associer la question à un/plusieurs cours
        foreach($jsonCours['cours'] as $Cours)
        {
            associerQuizCours($bdd, $idQuiz, $Cours['idCours']);
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

// supprimerUnQuiz
// Par Mathieu Dumoulin
function supprimerUnQuiz($idQuiz)
{
    try
    {
        supprimerQuiz($idQuiz);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

}

function convertStringBooleanToTINYINT($stringBoolean)
{
    return $stringBoolean=='true'?1:0;
}

// useless_error_handler
// Par Mathieu Dumoulin
// Description : Cette fonction set un error handler qui camoufle les erreurs PHP à l'utilisateur
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

