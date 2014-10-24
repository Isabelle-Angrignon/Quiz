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
            <li id="ajouterProf" class="ui-state-default padding nonImplementer">Ajouter un compte professeur</li>
            <li id="modifierCours" class="ui-state-default padding nonImplementer">Supprimer un professeur</li>
            <li id="nommerAdmin" class="ui-state-default padding nonImplementer">Nommer un nouvel administateur</li>
            <li id="modifierCours" class="ui-state-default padding nonImplementer">Modifier un cours</li>
        </ul>

    </div>

    </div>

</div>

<script>
    $('.nonImplementer').click(function(){
        swal("Désolé","Cette fonction n'est pas encore implémentées","error");
    });
    //Vue/Template/dynamique-ReinitialiserMotDePasse.php
    $('#reintinialiser').click(function(){
        CreerDeploiement('Vue/Template/dynamique-ReinitialiserMotDePasse.php');
    })

</script>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>