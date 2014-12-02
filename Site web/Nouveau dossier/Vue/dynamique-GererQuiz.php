<?php
    include("../Controleur/Utilitaires.php");
    include("../Modele/ModeleUtilisateurs.php");
    include("../Modele/ModeleQuiz.php");
    session_start();

    if(!isset($_SESSION['idUsager']) || !isset($_SESSION['etat']))
    {
        echo "<script> swal('Erreur de connexion','Erreur avec la connection. Veuillez vous reconnecter.', 'error');</script>";
        exit();
    }
    if($_SESSION['etat'] == "modifierQuiz")
    {
        if(isset($_SESSION['idQuiz']))
        {
            // Récuperation des informations de la bd par rapport à ce quiz
            $infoQuiz = recupererInfoQuiz($_SESSION['idQuiz']);
            $titreQuiz = $infoQuiz['titreQuiz'];
            $ordreQuestionsAleatoire = $infoQuiz['ordreQuestionsAleatoire'];
            $estDisponible = $infoQuiz['estDisponible'];
            $idProprietaire = $infoQuiz['idUsager_Proprietaire'];
        }
        else
        {
            // Gestion d'erreur si l'identifiant du quiz n'est pas reçu dans ce fichier et que c'est une modification de quiz
            echo "<script>
            fermerDivDynamique();
            swal(\"Erreur lors de l'ouverture\",\"Erreur lors de l'ouverture du quiz. Veuillez vous recommencer. Si le problème persiste, veuillez contacter un administrateur.\", 'error');
            </script>";

        }

        // Si l'usager propriétaire du quiz n'est pas l'usager courant, affiche un message pour signaler qu'aucune modif ne va être enregistrée dans la bd.
        if($idProprietaire != $_SESSION["idUsager"]) {
            echo "<script>swal('Oups',
                'Vous ne disposez pas des droits pour modifier ce quiz. Aucune modification ne sera sauvegardée.',
                'warning');</script>";
        }
    }
?>

<script>
    $(document).ready(function() {
        // ----------- Gestion des cours en javascript ---------------------------- //
        $("#DDL_Cours").children("option").each(function() {
            creerNouveauInput("checkbox","listeCoursQuiz", "cours", $(this).attr("value"), $(this).text(), 50);
            // Coche la checkbox des cours qui sont déjà lié à la question
        });
        $("#listeCoursQuiz input[type=checkbox]").click(function() {
            if($("#listeCoursQuiz input:checkbox:checked").length == 0) {
                $(this).prop('checked', true);
                swal("Erreur","Un quiz doit absolument être liée à un cours." ,"error");
            }
        });

        // --------------------------- Jquery UI ---------------------------------- //
        $("#paramQuiz").accordion({
            heightStyle:"content"
        }).disableSelection();

        $('#titreQuiz').on('keydown', function(e) {
            // Si on appui sur tab lorsqu'on est sur le titre du quiz
            if (e.which == 9) {
                if (!e.shiftKey) {
                    // On ouvre l'accordion à l'index 0.
                    $("#paramQuiz").accordion( "option", "active", 0 );
                }
            }
        });

        // Change le texte du boutton de l'ordre des questions dans le quiz lorsqu'on clique dessus.
        $("#ordreQuestionQuiz").button().change(function() {
            if($(this).prop("checked") == true) {
                $(this).next("label").children("span").text("Fixe");
            }
            else {
                $(this).next("label").children("span").text("Aléatoire");
            }
        });

        // Change le texte du boutton de la disponibilité du quiz lorsqu'on clique dessus.
        $("#disponibiliteQuiz").button().change(function() {
            if($(this).prop("checked") == true) {
                $(this).next("label").children("span").text("N'est pas disponible");
            }
            else {
                $(this).next("label").children("span").text("Est disponible");
            }
        });

        $("#BTN_EnregistrerQuiz").button();
        $("#BTN_SupprimerQuiz").button();

        // --------------------------- Paramètres de quiz  ---------------------------------- //
        $('#paramQuiz').on('keydown', function(e) {
            if (e.which == 9) {
                if (!e.shiftKey) {
                    // Ouvre l'index de l'accordion correspondante au tabIndex
                    var active = $( "#paramQuiz" ).accordion( "option", "active" );
                    $("#paramQuiz").accordion( "option", "active", active + 1 );
                }
            }
        });

        // --------------------------- Titre du quiz ---------------------------------- //
        // Gestion de la couleur de fond dans le titre du quiz selon s'il est focus ou non
        $("#titreQuiz").focusin(function(e) {
            $(this).css("background-color", "rgba(236, 99, 0, 0.62)");
        }).focusout(function(e) {
            $(this).css("background-color", "#E66100");
        });

        $("#titreQuiz").focus();

        // --------------------------- Gestion des événements sur le div dynamique ---------------------------------- //
        // Gestion du Ctrl + s sur un quiz qui sauvegarde les modifications/ajoute le quiz en simulant un clic sur le boutton BTN_EnregistrerQuiz
        $(document).keydown(function(e) {
            if(e.ctrlKey == true) {
                // e.which == s
                if(e.which == 83) {
                    prevenirDefautDunEvent(e, function() { $("#BTN_EnregistrerQuiz").click();});
                }
            }
        });

        // --------------------------- Gestion des événements sur les boutons de confirmation ---------------------------------- //
        // Sert à faire une boucle avec les tabIndex pour faciliter la navigation avec le tab
        $("#BTN_EnregistrerQuiz").keydown(function(e) {
            // Si tu pèse tab et que tu est sur le BTN_SupprimerQuiz
            if(e.which == 9)
            {
                $("#titreQuiz").focus();
                prevenirDefautDunEvent(e, function() {});
            }
        });
    });

</script>

<div id="sectionTitreQuiz">
    <input type="text" name="TitreQuiz" placeholder="Titre du quiz" id="titreQuiz" tabindex="1" value="<?php if($_SESSION['etat'] == "modifierQuiz") { echo htmlspecialchars($titreQuiz); } ?>">
</div>
<div id="paramQuiz">
    <h3>Ordre des questions</h3>
    <div tabindex="2">
        <ul>
            <input type="checkbox" id="ordreQuestionQuiz"
            <?php if($_SESSION['etat'] == "modifierQuiz" && $ordreQuestionsAleatoire == 0)
            {
                echo "checked><label for='ordreQuestionQuiz'>Fixe</label>";
            }
            else
            {
                echo "><label for='ordreQuestionQuiz'>Aléatoire</label>";
            }
            ?>
        </ul>
    </div>
    <h3>Disponibilité</h3>
    <div tabindex="3">
        <ul>
            <input type="checkbox" id="disponibiliteQuiz"
                <?php
                if($_SESSION['etat'] == "modifierQuiz" && $estDisponible == 0)
                {
                    echo "checked><label for='disponibiliteQuiz'>N'est pas disponible</label>";
                }
                else
                {
                    echo "><label for='disponibiliteQuiz'>Est disponible</label>";
                }
                ?>

        </ul>
    </div>
    <h3>Cours</h3>
    <div tabindex="4">
        <ul id="listeCoursQuiz">
            <?php
            if($_SESSION["etat"] == "modifierQuiz")
            {
                if(isset($_SESSION['idQuiz']))
                {
                    echo "<script>cocherCheckBoxCoursSelonQuiz(". $_SESSION['idQuiz'].");</script>";
                }
            }
            else if($_SESSION["etat"] == "nouveauQuiz")
            {
                echo "<script>cocherCheckBoxCoursSelonCoursCourant('listeCoursQuiz');</script>";
            }
            ?>
        </ul>
    </div>

</div>
<div id="validationQuiz">

    <input type="button" id="BTN_SupprimerQuiz" tabindex="6"
    <?php
    if($_SESSION['etat'] == 'modifierQuiz')
    {
        echo "value='Supprimer' onclick='supprimerQuiz(". $_SESSION['idQuiz']. ", \"". $_SESSION['idUsager'] ."\", \"$idProprietaire\")' >";
    }
    else
    {
        echo "value='Annuler' onclick='fermerDivDynamique()' >";
    }
    ?>
    <input type="button" id="BTN_EnregistrerQuiz"  tabindex="5"
    <?php
    if($_SESSION['etat'] == 'modifierQuiz')
    {
        echo "value='Enregistrer' onclick='modifierQuiz(". $_SESSION['idQuiz']. ", \"".$_SESSION['idUsager'] ."\", \"$idProprietaire\")' >";
    }
    else
    {
        echo "value='Ajouter' onclick='ajouterQuiz(\"".$_SESSION['idUsager'] ."\")' >";
    }
    ?>
</div>