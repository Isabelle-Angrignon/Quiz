<!DOCTYPE html>
<html>

<head>
	<?php 
		include("Vue/Template/InclusionTemplate.php");
		include("Vue/Template/InclusionJQuery.php");

	?>
	<link rel="stylesheet" href="Vue/CSS/Login.css" type="text/css" media="screen" >
</head>

<body>

	<?php		
		demarrerSession();
		redirigerSiDejaConnecte();		
		validerUsager();		
		include("Vue/Template/EnteteSite.php");
	?>
	
	<div class="contenu">
            <?php if ((isset($_SESSION['erreur'])) && (!empty($_SESSION['erreur'])))
            {
                echo ' <script>$(document).ready(function(){ swal({title:"Erreur" ,type:"warning", text:"'. $_SESSION['erreur'] .'"});});</script>';
            }
            ?>
        <div id="login">
            <p id="titreConnexion">Connexion</p>

            <form id="login_Form" method="post" action="../index.php">
                <div id="loginLabels">
                    <p >Nom d'usager </p>
                    <p >Mot de passe </p>
                </div>

                <div id="loginTextFields">
                    <input type="text" id="TBNomUsager" name="nomUsager" />
                    <input type="password" id="TBMotDePasse" name="motDePasse" />
                </div>

                <input type="submit" id="btnConnexion" value="Se connecter"/>
            </form>


            <p id="linkLostAcount"><a href="#">Mot de passe oublié ? </a></p>

        </div>

    </div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>

</body>

</html>