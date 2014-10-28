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
            entre autre une banque de questions de types vrai ou faux et d'autres à choix de réponse.
            D'autres types de questions pourront être implémentés ultérieurement.
        </p >
        <p class="centrer">
            Cet outil comporte plusieurs interfaces dont une pour les professeurs et les administrateurs
            et une autre pour les étudiants. Le QuizInfo sera particulièrement utile pour les étudiants
            de première année qui pourront s'en servir pour se pratiquer et ainsi augmenter leur
            potentiel de réussite et réduire les abandons du programme.  Ce sont les enseignants qui
            créent les questions et les agencent en quiz à soumettre aux étudiants.
        </p>

        <p> Ce projet a été supervisé par <b> Patrice Roy </b> et été livré à : <b>Stéphanne Chassé</b> , <b>Joan-Sébastien Morales</b>
            , <b>Étienne Forest</b></p>

        <h3>La page servant à répondre à des quiz</h3>
        <p class="centrer">Sur cette page, l'étudiant pourra sélectionner un quiz à droite pour y répondre
        ou appuyer sur le bouton "générer" qui lui fera passer un test avec des questions aléatoires selon
        le cours sélectionné.</p>
        <img class="screenshot" src="Vue/Images/RepondreQuestion.png" alt="logo" >


        <h3>La page servant à répondre à une question</h3>
        <p class="centrer">Sur cette page, l'étudiant répond aux question du quiz, une à la fois.  Il clic sur
            la réponse de son choix et puis sur valider.  Il voit dans l'entête son score se mettre à jour
            au fur et à mesure qu'il répond aux questions.  Après validation, il passe automatiquement à
            la question suivante.</p>
        <img class="screenshot" src="Vue/Images/RepondreQuestionDynamique.png" alt="logo" >


        <h3>La page servant à créer les quiz</h3>
        <p class="centrer">Dans la partie de gauche sont listées tous les quiz du professeur. Dans celle de droite sont
        listées toutes les questions associées à ce cours, peut importe l'auteur. La zone centrale permet d'associer les
        questions à un quiz. Il suffit de faire glisser un quiz sur la zone pointillée blanche et les questions déjà
        associées à ce quiz apparaitront dans la zone centrale.  On pourra en ajouter ou en retirer en les faissant
        glisser dans et hors de la zone.  On peut aussi déterminer l'ordre.  D'autres paramètres spécifiques au quiz
        pourront être choisis en cliquant sur l'engrenage.</p>
        <img class="screenshot" src="Vue/Images/Quiz-Question.png" alt="logo" >


        <h3>La page servant à créer des questions</h3>
        <p class="centrer"> Dans la zone orange on inscrit l'énoncé de la question. La zone bleu permet d'y inscrire
        les réponses qui seront offertes à l'étudiant et de cocher la bonne réponse attendue. La zone à droite regroupe
        les différents paramètres d'une question.  La question peut être associée à plusieurs cours et être disponible
        dans plusieurs types de quiz mais elle ne peut être que d'un seul type de question.</p>
        <img class="screenshot" src="Vue/Images/CreerQuestion.png" alt="logo" >


        <h3>La page servant à gérer ses groupes</h3>
        <p class="centrer"> Dans la partie de gauche sont listés les différents cours de la technique. Dans la partie de
        droite sont listés tous les étudiants de la technique. Lorsque un cours est glissé au centre de l'écran, cela
        permet d'ajoputer ou modifier les étudiants inscrits à ce cours et leur donne donc l'accès à tout quiz ou
        Question aléatoire associée à ce cours.</p>
        <img class="screenshot" src="Vue/Images/GererCours.png" alt="logo" >


        <h3>La page administrateur</h3>
        <p class="centrer">Cette page contient les différentes options auxquelles seuls les administrateurs ont
        accès comme:  supprimer un compte étudiant, modifier une description de cours ou encore réinitialiser un
        mot de passe</p>
        <img class="screenshot" src="Vue/Images/Admin.png" alt="logo" >


        <h3>La page servant à gérer son compte</h3>
        <p class="centrer">Cette page permet à un usager du site, étudiant ou enseignant, de modifier son mot de
        passe ou encore son adresse courriel.</p>
        <img class="screenshot" src="Vue/Images/GererCompte.png" alt="logo" >

    </div>
</div>

<?php  include("Vue/Template/BasDePage.php");  ?>

</body>

</html>