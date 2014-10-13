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

//Redirige à la bonne page d'accueil selon notre type d'usager
function redirigerUsager()
{
    $typeUsager = $_SESSION['typeUsager'];

    if ($typeUsager == 'Prof'|| $typeUsager == 'Admin' )
    {
        header('Location: Prof-GererQuiz.php');
    }
    elseif($typeUsager == 'Etudiant' )
    {
        header('Location: Etudiant-Accueil.php');
    }
    else
    {
        header('Location: Index.php');
    }
}
//Définit la variable de session Type d'usager selon qu'il est Étudiant, Prof ou Admin.
function definirTypeUsager($usager, $estAdmin )
{
    if ('4' == $usager[0])
    {
        if ($estAdmin)
        {
            $_SESSION['typeUsager'] = 'Admin';
        }
        else
        {
            $_SESSION['typeUsager'] = 'Prof';
        }
    }
    else
    {
        $_SESSION['typeUsager'] = 'Etudiant';
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
    echo '<script> ajouterOption_ToSelect( "'. $IdSelect . '" , "'.$idOption.'" , "'.$valeur.'" , true);</script>';
}



function GenererLi($idUi , $valeur , $idLi)
{
    echo "<script>ajouterLi_ToUl_V2( '". $idUi . "' , '".$valeur."' ,'".$idLi."', true);</script>";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////// Gestion d'erreur avec PHP ////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////// A vérifier si c'est toujours pertinent à la fin du sprint 1 //////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function my_error_handler($no, $str, $file, $line){
    switch($no){
        // Erreur fatale
        case E_USER_ERROR:
            echo '<p><strong>Erreur fatale</strong> : '.$str.'</p>';
            exit; // On arrête le script
            break;

        // Avertissement
        case E_USER_WARNING:
            echo '<p><strong>Avertissement</strong> : '.$str.'</p>';
            break;

        // Note
        case E_USER_NOTICE:
            echo '<p><strong>Note</strong> : '.$str.'</p>';
            break;

        // Erreur générée par PHP
        default:
            echo '<p><strong>Erreur inconnue</strong> ['.$no.'] : '.$str.'<br/>';
            echo 'Dans le fichier : "'.$file.'", à la ligne '.$line.'.</p>';
            break;
    }
}

set_error_handler('my_error_handler');

?>

