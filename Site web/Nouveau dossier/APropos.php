<!DOCTYPE html>
<html>

<head>
    <?php
    include("Vue/Template/InclusionJQuery.php");
    include("Vue/Template/InclusionTemplate.php");
    demarrerSession();
    ?>
    <link rel="stylesheet" href="Vue/CSS/APropos.css" type="text/css" media="screen" >
</head>

<body>

<?php
include("Vue/Template/EnteteSite.php");
if(isset($_SESSION['typeUsager']))
{
    if($_SESSION['typeUsager'] == 'Prof' ||$_SESSION['typeUsager'] == 'Admin')
    {
        include("Vue/Template/MenuProf.php"); 
    }
    else
    {
        include("Vue/Template/MenuEtudiant.php");
    }
}
?>

<div class="contenu">
    <div class = "centrer">
        <h1 id="header"> Le projet QuizInfo </h1>
        <img id="logo" src="Vue/Images/Logo_QIz.png" alt="logo" >
        <p class="centrer">
            Le QuizInfo est un outil de génération de quiz avec une base de données contenant
            entre autre une banque de questions de plusieurs types, entre autre des questions
            à choix de réponse unique, à réponses multiples et des questions de type vrai ou faux.
        </p >
        <p class="centrer">
            Cet outil comporte plusieurs interfaces dont une pour les professeurs et les administrateurs
            et une autre pour les étudiants. Le QuizInfo sera particulièrement utile pour les étudiants
            de première année qui pourront s'En servir pour se pratiquer et ainsi augmenter leur
            potentiel de réussite et réduire les abandons du programme.  Les enseignants créent
            des questions et les agencent en quiz à soumettre aux étudiants.
        </p>

        <hr>

        <h3>La page servant a réponde a des quiz</h3>
        <p class="centrer">Sur cette page l'étudiant pourra sélectionner un quiz a droit pour y répondre
        ou appuyer sur le bouton générer qui lui fera passer un test avec des questions aléatoires selon le cours
        sélectionner.</p>
        <img class="screenshot" src="Vue/Images/RepondreQuestion.png" alt="logo" >


        <h3>La page servant a réponde a une question pour des étudiants</h3>
        <p class="centrer">Sur cette pas l'étudiant répond à la question et appuie sur valider ce qui lui dit si
            il a obtenue une bonne réponse et le fait passer a la question suivante..</p>
        <img class="screenshot" src="Vue/Images/RepondreQuestionDynamique.png" alt="logo" >


        <h3>La page servant a créer des quiz</h3>
        <p class="centrer">Dans la partie de gauche sont lister tout les quizs du professeur. Dans celle de droite sont
        lister les questions que le professeur a pour ce cours. La zone centrale permet de joindre les deux. Il suffit de faire
        glisser un quiz sur la zone blanche et les questions du quiz apparaitrons dans la zone central ce qui permettra de les modifier.</p>
        <img class="screenshot" src="Vue/Images/Quiz-Question.png" alt="logo" >


        <h3>La page servant a créer des question</h3>
        <p class="centrer"> Dans la zone orange on inscrit l'énoncé de la question. La zone bleu permet d'y inscrire les réponses
        et de cocher la bonne réponses. La zone a droite regroupe les différents paramètres d'une question</p>
        <img class="screenshot" src="Vue/Images/CreerQuestion.png" alt="logo" >


        <h3>La page servant a gérer ces groupes</h3>
        <p class="centrer"> Dans la partie a gauche sont lister les différents cours de la technique. Dans la partie a droite sont
        lister tout les étudiants de la technique. Lorsque un cours est glisser au centre de l'écran cela permet de modifier les
        élèves inscrit a ce cours et donc l'accès au quiz.</p>
        <img class="screenshot" src="Vue/Images/GererCours.png" alt="logo" >


        <h3>La page administrateur</h3>
        <p class="centrer">Cette page contient les différentes options dont seul les administrateurs ont accès comme supprimer
        un compte ou encore réinitialiser un mot de passe</p>
        <img class="screenshot" src="Vue/Images/Admin.png" alt="logo" >


        <h3>La page servant a gérer son compte</h3>
        <p class="centrer">Cette page permet a un usager du site de modifier son mot de passe ou encore son adresse courriel.</p>
        <img class="screenshot" src="Vue/Images/GererCompte.png" alt="logo" >

    </div>
</div>

<?php  include("Vue/Template/BasDePage.php");  ?>

</body>

</html>