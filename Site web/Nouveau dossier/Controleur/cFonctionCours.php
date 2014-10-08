<?php

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
        $Donnee = LireCoursEtudiant( $_SESSION['idUsager'] );

        GenererOption($IdSelect, 'Tous mes cours', '0');

        foreach($Donnee as $Row)
        {
            GenererOption($IdSelect, $Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
        }
    }
    else
    {
        $Donnee = LireCours();
        foreach($Donnee as $Row)
        {
            GenererOption($IdSelect,$Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
        }
    }
}

//InsererCours();

function ListerCoursDansUl($IdUl)
{
    $Donnee = LireCours();
    foreach($Donnee as $Row)
    {
        GenererLi($IdUl,$Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
    }
}

function InsererEleves()
{
    $Donnee = LireEtudiant();
    foreach($Donnee as $Row)
    {
        GenererLi('UlEtudiants',$Row['nom'] . ' ' . $Row['prenom'], $Row['idUsager']);
    }
}

?>