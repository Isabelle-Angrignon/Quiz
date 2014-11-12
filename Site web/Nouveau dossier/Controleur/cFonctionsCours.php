<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  cFonctionCours.php
//  Fait par : Simon Bouchard et Mathieu Dumoulin
//  Commenter le : 12/11/2014
//
//  Description :
//  Fichiers contenant les fonctions du type controleur en ce qui concerne les cours
//
////////////////////////////////////////////////////////////////////////////////////////////////////
/*
    Nom: ListerCoursDansSelect
    Par: Mathieu Dumoulin
    Date: 03/10/2014
    Intrants: $IdSelect = Le id du select Parent, $tousMesCours = Un boolean qui représente si on affiche un Option de Tous mes cours
    Extrant(s): Des balises options automatiquement affectés à un Select dans le DOM
    Description: Cette fonction communique à la BD à l'aide de la fonction LireCours() et ajoute des options pour chacune des rows du résultat
*/
function ListerCoursDansSelect($IdSelect, $tousMesCours)
{
    if($tousMesCours)
    {
        $Donnee1 = LireCoursEtudiant( $_SESSION['idUsager'] );

        $_SESSION['listeCours'] = $Donnee1;
        GenererOption("DDL_Cours", "Tous mes cours", "0");
        foreach($Donnee1 as $Row)
        {
            GenererOption($IdSelect, $Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
        }
    }
    else
    {
        $Donnee = LireCours();

        $_SESSION['listeCours'] = $Donnee;
        $_SESSION['PremierCours'] = $Donnee[0]['idCours'];
        foreach($Donnee as $Row)
    {
        GenererOption($IdSelect, $Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
    }
    }
}


// ListerCoursDansUI
// Permet d'insérer un eleve dans un li
// fait par : Simon Bouchard
// Intrant : Le Ui dans lequel il faut ajouter les li
// Extrant: Aucun

function ListerCoursDansUl($IdUl)
{
    $Donnee = LireCours();
    foreach($Donnee as $Row)
    {
        GenererLi_V2($IdUl,substr($Row['nomCours'],0,25), $Row['idCours'],$Row['codeCours'],"divDansLi");
    }
}

// InsererEleves
// Permet d'inserer un eleve dans un li
// fait par :  Simon Bouchard
// Intrant : Le UI dans lequels il faut ajouter les Li
// Extrant : Aucun

function InsererEleves()
{
    $Donnee = LireEtudiant();
    foreach($Donnee as $Row)
    {
        GenererLi_V2('UlEtudiants',$Row['nom'] . ' ' . $Row['prenom'], $Row['idUsager'],$Row['idUsager'],"divDansLi");
    }
}

?>