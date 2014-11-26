<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    redirigerSiNonConnecte('Admin');
    ?>
    <link rel="stylesheet" href="Vue/CSS/Admin.css" type="text/css" media="screen" >
    <link rel="stylesheet" href="Vue/CSS/GererSonCompte.css" type="text/css" media="screen" >
    <script src="Javascript/Admin.js"></script>
    <script src="Javascript/GererCours.js"></script>

</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php



?>

<div class="contenu" >
    <div id="leConteneur">
    <div id="optionCours"class="Liste">
        <label>Options</label>
        <ul id="optionAdmin">
            <li id="reintinialiser" class="ui-state-default padding">Réinitialiser un mot de passe</li>
            <li id="ajouterProf" class="ui-state-default padding ">Ajouter un compte professeur</li>
            <li id="supprimerCompte" class="ui-state-default padding">Supprimer un compte</li>
            <li id="nommerAdmin" class="ui-state-default padding ">Nommer un nouvel administateur</li>
            <li id="modifierCours" class="ui-state-default padding ">Modifier un cours</li>
            <li id="NouveauCours" class="ui-state-default padding ">Ajouter un nouveau cours</li>
            <li id="info" class="ui-state-default padding ">Information</li>
        </ul>

    </div>

    </div>

</div>

<script>
    $('#modifierCours').click(function(){
        CreerDeploiement('Vue/dynamique-ModifierCours.php');
    });
    $("#NouveauCours").click(function(){
        CreerDeploiement('Vue/dynamique-CreerCours.php');
    })
    //Vue/Template/dynamique-ReinitialiserMotDePasse.php
    $('#reintinialiser').click(function(){
        CreerDeploiement('Vue/dynamique-ReinitialiserMotDePasse.php');
    });
    $('#ajouterProf').click(function(){
        CreerDeploiement('Vue/dynamique-AjouterProf.php');
    });
    $('#supprimerCompte').click(function(){
        CreerDeploiement('Vue/dynamique-SupprimerUnCompte.php');
    });
    $('#nommerAdmin').click(function(){
        CreerDeploiement('Vue/dynamique-NommerAdmin.php');
    });
    $('#info').click(function(){
        CreerDeploiement('Vue/dynamique-InfoAdmin.php');
    });

</script>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>