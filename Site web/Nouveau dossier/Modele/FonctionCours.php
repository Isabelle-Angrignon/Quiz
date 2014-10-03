<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 01/10/2014
 * Time: 09:08
 */

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

function GenererLi($idUi , $valeur , $idLi)
{
    //echo "<script>ajouterLi_ToUl_V2( " . $idUi . " , " . $valeur . " , " . $idLi . " , true);</script>";
    echo "<script>ajouterLi_ToUl_V2( '". $idUi . "' , '".$valeur."' ,'".$idLi."', true);</script>";
}

function LireCours()
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $requete = $bdd->prepare("CALL listerCours()");
    $requete->execute();
    $resultat = $requete->fetchAll();
    return $resultat;
}
function LireEtudiant(){
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $requete = $bdd->prepare("CALL listerEtudiants()");
    $requete->execute();
    $resultat = $requete->fetchAll();
    return $resultat;

}

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
    $Donnee = LireCours();
    if($tousMesCours)
    {
        GenererOption($IdSelect, 'Tous mes cours', '0');
    }
    foreach($Donnee as $Row)
    {
        GenererOption($IdSelect,$Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
    }
}

function GenererOption($IdSelect, $valeur, $idOption)
{
    echo "<script>ajouterOption_ToSelect( '". $IdSelect . "' , '".$idOption."' , '".$valeur."' , true);</script>";
}