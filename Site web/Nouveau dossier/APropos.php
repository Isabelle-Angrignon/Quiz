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
        <h1> Le projet QuizInfo </h1>
        <img id="logo" src="Vue/Images/Logo_QI_ico.png" alt="logo" >
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

        <p class="centrer"> Ce projet a été supervisé par <b> Patrice Roy</b>.
        <br/>
            Les représentants clients sont les enseignants de première session suivant :<br/>
            <b>Stéphanne Chassé</b>, <b>Joan-Sébastien Morales</b> et <b>Étienne Forest</b>
        </p>
        <br/>

        <hr/>
        <h1>Explications des principales interfaces</h1>

        <h3>Page de gestion de compte</h3>
        <p class="centrer">Cette page permet à un usager du site, étudiant ou enseignant, de modifier son mot de
            passe ou encore son adresse courriel.  Noter que l'adresse courriel n'est pas encore utilisée dans
            l'application.</p>
        <img class="screenshot" src="Vue/Images/GererCompte.png" alt="logo" >

        <h3>Page d'accueil des étudiants : Choix des quiz</h3>
        <p class="centrer">Sur cette page, l'étudiant trouvera la liste de tous les quiz formatifs pour les cours auquels
            il est inscrit peut importe l'enseignant qui les a préparés.  Il pourra filtrer sa liste par cours à l'aide
            du menu déroulant.
        </p>
        <p class="centrer">Le bouton "Générer" lui permettra de répondre à toutes les questions en ordre aléatoire pour le
            cours sélectionné.  Dans ce type de quiz, l'étudiant peut quitter quand il le désire et ses statistiques
            ne seront pas compilées. Il s'agit donc d'un outil de pratique.
        </p>
        <img class="screenshot" src="Vue/Images/RepondreQuestion.png" alt="logo" >
        <br/>
        <h3>Page d'ouverture d'un quiz: Répondre à une question</h3>
        <p class="centrer">Cette page s'affiche pour chaque question d'un quiz (formatif ou aléatoire).
            Dans l'entête, l'étudiant voit le titre du cours (et du quiz si formatif) ainsi que le nom de son professeur
            (ou de l'auteur du quiz si formatif).  Il voit également son score se mettre à jour au fur et à mesure qu'il
            répond aux questions.  Il voit le nombre de bonnes réponses qu'il a obtenu sur le nombre de question répondues
            à date.  S'il s'agit d'un quiz formatif, il voit également le nombre total de questions qu'il aura à répondre.
            Un "pop-up" avisera du score final une fois le quiz formatif terminé ou si l'étudiant à répondu à toutes les questions
            aléatoires du cours.
        </p>
        <p class="centrer">
            L'étudiant peut quitter un quiz en tout temps en cliquant en dehors de la fenêtre de question ou en
            cliquant sur "esc".  S'il répondait à un quiz formatif, une demande de confirmation s'affichera puisque la
            fermeture du quiz lui ferait perdre sa progression.  Le fait de compléter un quiz formatif génère des statistiques
            utiles aux professeurs qui peuvent s'en servir pour mieux cibler les matières moins comprises par exemple.
        </p>
        <p class="centrer">
            L'étudiant lit l'énoncé et répond à la question en cliquant simplement sur sa réponse. Il peut changer d'idée
            tant qu'il n'a pas cliqué sur "valider" après quoi la bonne réponse s'affiche en vert et il ne peut plus changer
            sa réponse.  S'il n'a pas choisi la bonne réponse, sa propre réponse sera en rouge.  Si l'étudiant éprouve
            un problème avec la question ou les choix de réponses, il peut prendre en note le cours, le "id" de la question
            et le nom du professeur qui a rédigé la question et rapporter ces informations à son propre professeur qui
            pourra facilement retrouver la question et répondre à l'étudiant. En cliquant sur suivant, il passe automatiquement à
            la question suivante.
        </p>
        <p class="centrer">
            Notez que pour les question générées en mode aléatoire, si le professeur à définit un champs "lien vers
            références" pour sa question, l'étudiant qui répond incorrectement à cette question se verra offri l'option
            d'accéder au lien suggéré par le professeur.  Ainsi, il n'aura pas automatiquement la bonne réponse et pourra
            tenter de répondre encore à la question.  Il peut également ignorer le lien et simplement continuer le quiz.
            </p>
        <img class="screenshot" src="Vue/Images/RepondreQuestionDynamique.png" alt="logo" >
        <br/>
        <h3>Page d'accueil des professeurs: Quiz et questions</h3>
        <p class="centrer">Sur cette page sont affichés tous les quiz et toutes les questions pour le cours choisi dans
            le menu déroulant, peut importe l'auteur.</p >
        <p class="centrer">
            Dans la partie de gauche sont listés les quiz. Dans celle de droite sont listés les questions. La zone centrale
            permet d'associer les questions à un quiz. Il suffit de faire glisser un quiz sur la zone pointillée blanche
            et les questions déjà associées à ce quiz apparaitront dans la zone centrale et disparaîtront de la liste de
            droite ne laissant que les questions disponibles.  On pourra ajouter ou retirer des questions au quiz simplement
            en les faissant glisser dans et hors de la zone centrale.  On peut aussi déterminer l'ordre des questions en les réordonnant.
            Pour faciliter la recherche de questions, on peut utiliser les champs de filtre "id" et/ou "Énoncé" qui
            s'appliqueront à la liste de question de droite seulement.  Donc si la question recherchée est listée dans la
            zone centrale, elle ne ressortira pas du lot.
            On ajoute des quiz et des questions en cliquant sur le bouton approprié et on peut en modifier les paramètres
            ultérieurement en cliquant simplement sur l'item souhaité.
            Les attributs paramétrables des quiz sont: le titre, l'option fixe/aléatoire de l'ordre des questions et
            les cours auquels le quiz est associé.  Ainsi, si un quiz doit être disponible autant pour un cours de
            gestion que d'industriel, il sera possible de l'associer à deux cours</p>
        <img class="screenshot" src="Vue/Images/Quiz-Question.png" alt="logo" >
        <br/>
        <h3>Page de modification ou d'ajout de questions</h3>
        <p class="centrer"> <b>Question : </b>zone orange, énoncé de la question.
        </p>
        <p class="centrer"><b>Réponses : </b>zone bleu, permet d'y inscrire une liste de choix de réponses offertes à l'étudiant.
            Ojn doit cocher la bonne réponse attendue.  L'ordre des réponses peut
            être fixe ou aléatoire.  On peut modifier l'ordre en cliquant et glissant les réponses.  Le focus ne doit pas être
            sur une réponse pour pouvoir faire un déplacement.
        </p>
        <p class="centrer"><b>Lien Web : </b>Il s'agit de proposer un lien vers des notes de cours ou un site de référence qui
            permettra à l'étudiant de trouver la réponse à la question ou des explications.
            Notez que les étudiant n'auront pas accès à ce lien en quiz formatif mais seulement en quiz aléatoire.
            Le type de quiz aléatoire doit donc être coché pour que l'étudiant puisse avoir accès au lien en cas de mauvaise réponse.
        </p>
        <p class="centrer"><b>Type de quiz associé : </b>Cette fonctionnalité permet de décider si une question est réservée à la
            pratique seulement, aux quiz formatif seulement ou aux deux types.
        </p>
        <p class="centrer">ALÉATOIRE: La question sera disponible en tout temps et à tout moment de la session, dès qu'un étudiant
            est inscrit au cours.  Également, le lien Web sera offert en cas de mauvaise réponse.
        </p>
        <p class="centrer">FORMATIF : Si coché, la question sera listée dans le menu de droite lorsq'un quiz sera dans la zone de
            modification. Sinon, la question ne pourra pas être associée à un quiz.
        </p>
        <p class="centrer"><b>Type de question : </b>Les types disponibles pour l'instant sont choix multiple à réponse unique et
            vrai/faux.
        </p>
        <p class="centrer"><b>Cours : </b>Liste des cours associés à la question. Ici aussi, si une question doit être disponible autant
                pour un cours de gestion que d'industriel, il sera possible de l'associer à deux cours.
        </p>
        <p class="centrer">Remarquez qu'il existe plusieurs touches raccourcis pour accélérer la saisi des questions et réponses.
            Elles sont décrites sur l'interface.
        </p>
        <img class="screenshot" src="Vue/Images/CreerQuestion.png" alt="logo" >
        <br/>
        <h3>Page de gestion des groupes</h3>
        <p class="centrer">Cette page sert essentiellement à associer des étudiants à un cours.  Les étudiants ne peuvent
            avoir accès ni aux quiz, ni aux questions s'ils ne sont pas associés au cours.  En revanche, s'ils sont
            inscrits à un cours, il auront accès aux quiz et questions peut importe l'auteur.  Pour ajouter un cours ou
            modifier un nom de cours ou son code, demandez à un administrateur.
        </p>
        <p class="centrer">
            Donc, dans la partie de gauche sont listés les différents cours disponibles. Dans la partie de
            droite sont listés tous les étudiants de la technique inscrits au QuizInfo. La zone centrale permet d'associer
            les étudiants à un cours. Il suffit de faire glisser un cours sur la zone pointillée blanche et les étudiants
            déjà associées à ce cours apparaitront dans la zone centrale et disparaîtront de la liste de droite ne laissant
            que les étudiants disponibles.  On peut rapidement ajouter tout un groupe à partir du fichier .csv exporté
            par Colnet.  Notez que si c'est la première inscription à un cours pour les étudiants, leur compte est
            également créé durant cette opétration.  On peut également désinscrire tous les étudiant d'un coup avec la
            fonction "vider".  Noter que ceci ne supprime pas les comptes étudiants.
        </p>
        <p class="centrer">
            Pour les cas spéciaux, on pourra inscrire manuellement un nouvel étudiant avec le bouton "ajouter".  On peut
            également ajouter ou retirer des étudiants au cours en les faissant glisser dans et hors de la zone centrale.
            Finalement. le bouton "Reinit. MDP"  Permet de réinitialiser un mot de passe étudiant.  Notez d'abord son #DA
            en bas à droite de son nom dans la liste et entrez le manuellement dans le champs de la fenêtre générée par
            ce bouton.
            </p>
        <img class="screenshot" src="Vue/Images/GererCours.png" alt="logo" >
        <br/>
        <h3>Page statistiques</h3>
        <p class="centrer">Cette option permet de télécharger toutes les statistiques cumulées de la base de donnée
            depuis sa création dans un fichier csv.  On obtient  un "enregistrement" par combinaison de
            étudiant-Quiz-Question.  Pour chaque enregistrement, on aura les deux statistiques suivantes :
            le nombre de fois répondues et le nombre de bonnes réponses.  Plusieurs autres informations pertinentes sont
            fournies telles que le titre du quiz, l'énoncé de question, le nom du cours, etc.
        </p >
        <p class="centrer">
            Des instructions sur le processus d'extraction des données en Excel sont fournies au début du fichier qui
            sera téléchargé à l'emplacement par défaut du fureteur.
            <br/>
            <br/>
        </p>
        <br/>
        <h3>Page administrateur</h3>
        <p class="centrer">Cette page est disponible seulement pour les professeurs ayant le statut d'administrateur.
            Elle permet d'exécuter différentes actions dont seuls les administrateurs ont accès tel que : réinitialiser
            un mot de passe professeur ou étudiant, ajouter un nouveau professeur, nommer un nouvel administrateur,
            supprimer un compte étudiant, modifier une description ou un code de cours, ajouter un nouveau cours et
            finalement donne l'accès aux informations qui donne les droits pour modifier le document technique accessible
            à droite dans le pied de page.  Notez que ce document technique est disponible en lecture seule pour tous
            les professeurs.
        </p>
        <img class="screenshot" src="Vue/Images/Admin.png" alt="logo" >

    </div>
</div>

<?php  include("Vue/Template/BasDePage.php");  ?>

</body>

</html>