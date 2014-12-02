<!DOCTYPE html>
<html>

<head>
	<?php
		include("Vue/Template/InclusionJQuery.php");
        include("Vue/Template/InclusionTemplate.php");
	?>
	<link rel="stylesheet" href="Vue/CSS/Login.css" type="text/css" media="screen" >
</head>

<body>
<!--[if IE]>
<h1 style="text-align:center"> Ce site web ne supporte pas internet explorer </h1>
<hr/>
<p style="text-align:center"> Veuillez utiliser firefox ou chrome </p>
<![endif]-->
<![if !IE]>
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
                unset($_SESSION['erreur']);
            }
            ?>
        <div id="login">
            <p id="titreConnexion">Connexion</p>
            <hr>
            <form id="login_Form" method="post" action="index.php">
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
        </div>
        <div id="avertissementBrowser"><b>Avertissement</b> : le QuizInfo n'est pas stable avec Firefox sur les ordis du Collège Lionel-Groulx. Ce problème est externe à notre projet. Pour une version plus stable, veuillez utiliser Chrome.</div>
    </div>
    <script>
        $("#btnConnexion").button();
        $(document).ready(function(){
            $("#TBNomUsager").focus();
        });
    </script>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>
<![endif]>
</body>

</html>