<!--
Fonctions.php
Auteur: Isabelle Angringnon
Date: 23 septembre 2014
But: Contient diverses fonctions génériques 

-->


<?php
// L'équivalent du classique getInstance d'un singleton de session
function demarrerSession()
{
    session_start();
}

//Utilisé à la page index...
//Vérifie si on a une session connecté.  Si oui, nous redirige
//vers notre page d'accueil selon qu'on est prof ou étudiant.
function redirigerSiDejaConnecte()
{
    if (isset($_SESSION['idUsager']))
    {
        redirigerUsager();
    }
}

//Utiliser à chaque page.
//Vérifie si on a une session connecté.  Si non, nous redirige
//vers la page d'index.
function redirigerSiNonConnecte()
{
    if (!isset($_SESSION['idUsager']))
    {
        header('Location: Index.php');
    }
}

//Détermine notre type d'usager: les profs d'info commencent tous pas 420
function redirigerUsager()
{
    $usager = $_SESSION['idUsager'];

    if ('4' == $usager[0])
    {
        //Prof
        $_SESSION['typeUsager'] = 'prof';
        //redirect
        header('Location: Vue/Pages/Prof-GererQuiz.php');
    }
    else
    {
        //etudiant
        $_SESSION['typeUsager'] = 'etudiant';
        //redirect
        header('Location: Vue/Pages/Etudiant-Accueil.php');
    }
}

/*
    Nom: GenererOption
    Par: Mathieu Dumoulin
    Date: 06/10/2014
    Intrants: $IdSelect : L'id du select parent
              $valeur : le texte que la balise option doit contenir
              $idOption : le id du nouveau option
*/
function GenererOption($IdSelect, $valeur, $idOption)
{
    // Important de mettre des guillemets (") comme marqueur de paramètre au lieu des apostrophes(') car si la variable contient des apostrophes, Chrome te sort des erreurs
    echo '<script>ajouterOption_ToSelect( "'. $IdSelect . '" , "'.$idOption.'" , "'.$valeur.'" , true);</script>';
}



function GenererLi($idUi , $valeur , $idLi)
{
    echo "<script>ajouterLi_ToUl_V2( '". $idUi . "' , '".$valeur."' ,'".$idLi."', true);</script>";
}

?>

