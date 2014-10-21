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
		redirigerSiNonConnecte('Usager');
		include("Vue/Template/EnteteSite.php");
        //faire un if sur $_SESSION["typeUsager"]
        if ($_SESSION['typeUsager'] == 'Prof' || $_SESSION['typeUsager'] == 'Admin' ) {
            include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
        }
        else{
            include("Vue/Template/MenuEtudiant.php");
        }

	?>
	
	<div class="contenu">





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
                    <?php echo $_SESSION['Nom']; ?> <br>
                    <?php echo $_SESSION['Prenom']; ?>  <br>
                    <?php echo $_SESSION['idUsager']; ?>  <br>
                </div>
            </div>
                <p class="titre">Mon Courriel</p>
                <hr>
                    <form class="conteneur" method="post" action="../Controleur/ChangerEmail.php">
                        <div class="gauche">
                            <label>Courriel actuel </label> <br>
                            <label>Nouveau Couriel </label> <br>
                            <label>Confirmer le nouveau Couriel</label>
                        </div>

                        <div class="droite">
                            <label><?php echo recupererAdresseEmail($_SESSION['idUsager'])[0]; ?></label> <br>
                            <input type="text" id="TBNomUsager" name="Email" /> <br>
                            <input type="text" id="TBMotDePasse" name="ConfirmationEmail" />
                        </div>
                        <br>
                        <button type="submit" >Changer son courriel</button>
                    </form>
                <p class="titre">Mot de passe</p>
                <hr>
            <form class="conteneur" method="post" action="Controleur/ChangerMotDePasse.php">
                <div class="gauche">
                    <label>Ancien mot de passe </label> <br>
                    <label>Nouveau mot de passe </label> <br>
                    <label>Confirmer le nouveau mot de passe</label>
                </div>

                <div class="droite">
                    <input type="password" id="TBNomUsager" name="AncienMotPasse" /> <br>
                    <input type="password" id="TBNomUsager" name="NouveauMotPasse" /> <br>
                    <input type="password" id="TBMotDePasse" name="ConfNouveauMotPasse" />
                </div>
                <br>
                <button type="submit" >Changer son mot de passe</button>
            </form>
        </div>



        <?php if ((isset($_SESSION['erreur'])) && (!empty($_SESSION['erreur']))) {
            echo ' <script>$(document).ready(function(){ swal({title:"Erreur" ,type:"warning", text:"'. $_SESSION['erreur'] .'"});});</script>';
        }
        ?>




    </div>
	
	<?php
		include("Vue/Template/BasDePage.php");
	?>

</body>

</html>