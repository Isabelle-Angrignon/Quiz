<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 01/10/2014
 * Time: 09:08
 */



function InsererCours()
{
    $Donne = LireCours();
    foreach($Donne as $Row)
    {
       echo "<script>ajouterLi_ToUl_V2('UlCours',$Row[codeCours] . ' ' . $Row[nomCours],'C' . $Row[idCours],true) </script>";
    }
}

function LireCours()
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');
    $requete = $bdd->prepare("CALL listerCours()");
    $requete->execute();
    $resultat = $requete->fetchAll();
    return $resultat;
}
function LireEtudiant(){
    $bdd = new PDO('mysql:host=localhost;dbname=projetquiz', 'root', '');
    $requete = $bdd->prepare("CALL listerEtudiants()");
    $requete->execute();
    $resultat = $requete->fetchAll();
    return $resultat;

}