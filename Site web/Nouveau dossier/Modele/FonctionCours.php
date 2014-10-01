<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 01/10/2014
 * Time: 09:08
 */

//InsererCours();

function InsererCours()
{
    $Donnee = LireCours();
    foreach($Donnee as $Row)
    {
      GenererLi('UlCours',$Row['codeCours'] . ' ' . $Row['nomCours'], $Row['idCours']);
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