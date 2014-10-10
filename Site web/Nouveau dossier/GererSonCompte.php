<!DOCTYPE html>
<html>

<head>
	<?php
        include("Vue/Template/InclusionJQuery.php");
		include("Vue/Template/InclusionTemplate.php");
	?>
    <link rel="stylesheet" href="Vue/CSS/GererSonCompte.css" type="text/css" media="screen" >
</head>

<body>

	<?php
		demarrerSession();
		//redirigerSiNonConnecte();
		include("Vue/Template/EnteteSite.php");
        //faire un if sur $_SESSION["typeUsager"]
		include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
	?>
	
	<div class="contenu">


            <?php if ((isset($_SESSION['erreur'])) && (!empty($_SESSION['erreur']))) {
                echo '
                <div id="alerte" class="Alerte">
                '. $_SESSION['erreur'] .'
                </div>
                ';
            }
            ?>


        <div id="login">
            <p class="titre">Mon Compte</p>
            <hr>
            <div class="conteneur" >
                <div class="gauche">
                    Nom <br>
                    Prenom <br>
                    Numero de DA <br>
                </div>

                <div class="droite">
                    Bouchard <br>
                    Simon <br>
                    201237936 <br>
                </div>
            </div>
                <p class="titre">Mon Courriel</p>
                <hr>
                    <form class="conteneur" method="post" action="../index.php">
                        <div class="gauche">
                            <label>Courriel actuel </label> <br>
                            <label>Nouveau Couriel </label> <br>
                            <label>Confirmer le nouveau Couriel</label>
                        </div>

                        <div class="droite">
                            <label> 851s2001@gmail.com</label> <br>
                            <input type="email" id="TBNomUsager" name="nomUsager" /> <br>
                            <input type="email" id="TBMotDePasse" name="motDePasse" />
                        </div>
                        <br>
                        <button type="submit" >Changer son courriel</button>
                    </form>
                <p class="titre">Mot de passe</p>
                <hr>
            <form class="conteneur" method="post" action="../index.php">
                <div class="gauche">
                    <label>Ancien mot de passe </label> <br>
                    <label>Nouveau mot de passe </label> <br>
                    <label>Confirmer le nouveau mot de passe</label>
                </div>

                <div class="droite">
                    <input type="password" id="TBNomUsager" name="nomUsager" /> <br>
                    <input type="password" id="TBNomUsager" name="nomUsager" /> <br>
                    <input type="password" id="TBMotDePasse" name="motDePasse" />
                </div>
                <br>
                <button type="submit" >Changer son mot de passe</button>
            </form>
        </div>








    </div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>

</body>

</html>