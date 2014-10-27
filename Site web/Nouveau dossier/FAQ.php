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
    <p class="reponse">Ce n'est pas a l'étudiants de s'inscrire. Lorsque'un professeur vous inscira a son cours vous serez
    automatiquement inscrit comme étudiants avec comme mot de passe votre numero de DA</p>
    <br>
    <h3>Je suis inscrit mais je ne sais pas quel est mon mot de passe ?</h3>
    <p class="reponse">Par défaut votre mot de passe et votre numéro de DA</p>
    <br>
    <h3>J'ai perdu mon mot de passe comment fais-je pour le réinitialiser ?</h3>
    <p class="reponse">Contactez un administateur ils sont les seuls capable de réinitialiser un mot de passe</p>
    <br>
    <h3>Je suis un professeur au collège Lionnl-Groulx et j'aimerais avoir un compte ?</h3>
    <p class="reponse">Si vous êtes un professeur appartement au département d'informatique il vous suffit de prendre contacte avec un
        administrateurs. Ces derniers pourront vous créer un compte</p>
    <br>

</div>

<?php
include("Vue/Template/BasDePage.php");
?>

</body>

</html>