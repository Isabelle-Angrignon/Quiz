<?php

// recupererReponsesQuestion
// Par: Mathieu Dumoulin
// Date: 13/10/2014
// Description: Cette fonction retourne toutes les réponses liés à une question. Si cette question est un vrai ou faux, il n'y aura aucune réponse car
//              les réponses de questions de type vrai/faux sont contenues dans la fonction recupererReponsesVraiFaux
function recupererReponsesAQuestion($idQuestion)
{
    $bdd = getConnection("prof"); ////////////////// À modifier avec la session et le typeUsager de la session /////////////////////////////////////////

    if (isset($idQuestion))
    {
        $requete = $bdd->prepare("CALL recupererReponsesAQuestion(?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);

        $requete->execute();

        $reponses = $requete->fetchAll();
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd
    return $reponses;
}

// recupererReponsesVraiFaux
// Par: Mathieu Dumoulin
// Date: 13/10/2014
// Description: Cette fonction retourne toutes les réponses liés à une question de type Vrai/Faux
function recupererReponsesVraiFaux($idQuestion)
{
    $bdd = getConnection("prof"); ////////////////// À modifier avec la session et le typeUsager de la session /////////////////////////////////////////

    if (isset($idQuestion))
    {
        $requete = $bdd->prepare("CALL recupererReponsesVraiFaux(?)");
        $requete->bindparam(1, $idQuestion, PDO::PARAM_INT,10);

        $requete->execute();

        $reponses = $requete->fetchAll();
        $requete->closeCursor();
    }
    unset($bdd);// fermer connection bd
    return $reponses;
}