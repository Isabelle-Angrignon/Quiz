<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    ?>
    <link rel="stylesheet" href="Vue/CSS/FAQ.css" type="text/css" media="screen" >
</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
if(isset($_SESSION['typeUsager']))
{
    if($_SESSION['typeUsager'] == 'Prof' ||$_SESSION['typeUsager'] == 'Admin')
    {
        include("Vue/Template/MenuProf.php");   // ou MenuEtudiant.php
    }
    else
    {
        include("Vue/Template/MenuEtudiant.php");
    }
}

?>

<div class="contenu">

<h1>Foire aux questions (FAQ)</h1>
    <hr>
    <h3>Comment fait-on pour s'inscrire ?</h3>
    <p class="reponse">Ce n'est pas à l'étudiant de s'inscrire. Lorsque'un professeur vous inscira à son cours pour
    vous donner accès à ses questions et quiz, votre compte d'étudiant sera automatiquement créé avec votre numero de
    DA comme nom d'usager et mot de passe.  Vous devrez obligatoirement modifier votre mot de passe à la première
    connexion.</p>
    <br>
    <h3>Je suis inscrit mais je ne sais pas quel est mon mot de passe ?</h3>
    <p class="reponse">Par défaut, votre mot de passe est votre numéro de DA</p>
    <br>
    <h3>J'ai oublié mon mot de passe.  Comment fais-je pour le réinitialiser ?</h3>
    <p class="reponse">Contactez un professeur.  Il fera la demande à un administateur s'il n'a pas le pouvoir de le
    réinitialiser.</p>
    <br>
    <h3>Je suis un professeur au collège Lionnel-Groulx. Comment faire pour avoir un compte ?</h3>
    <p class="reponse">Pour le moment, seuls les professeurs du département d'informatique peuvent utiliser le QuizInfo.
    Si c'est votre cas, il vous suffit de prendre contact avec un administrateur. Ce dernier pourra vous
    créer un compte.</p>
    <br>

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>