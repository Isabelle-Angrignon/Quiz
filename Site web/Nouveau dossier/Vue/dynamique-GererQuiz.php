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
        $infoQuiz = recupererInfoQuiz($_SESSION['idQuiz']);
        $titreQuiz = $infoQuiz['titreQuiz'];
        $ordreQuestionsAleatoire = $infoQuiz['ordreQuestionsAleatoire'];
        $estDisponible = $infoQuiz['estDisponible'];
    }
?>

<script>
    $(document).ready(function() {
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
        $("#paramQuiz").accordion({
            heightStyle:"content"
        }).disableSelection();/*.children("div").focusin(function(e){
            var currentTabIndex = document.activeElement.tabIndex;
            $(this).parent("#paramQuiz").accordion("option", "active", currentTabIndex - 1 );
        });*/

        $('#titreQuiz').on('keydown', function(e) {
            if (e.which == 9) {
                if (!e.shiftKey) {
                    $("#paramQuiz").accordion( "option", "active", 0 );
                }
            }
        });
        $('#paramQuiz').on('keydown', function(e) {
            if (e.which == 9) {
                if (!e.shiftKey) {
                    var active = $( "#paramQuiz" ).accordion( "option", "active" );
                    $("#paramQuiz").accordion( "option", "active", active + 1 );
                }
            }
        });

        $('#BTN_SupprimerQuiz').on('keydown', function(e) {
            if (e.which == 9) {
                if (!e.shiftKey) {
                    $("#titreQuiz").focus();
                }
            }
        });

        $("#titreQuiz").focusin(function(e) {
            $(this).css("background-color", "rgba(236, 99, 0, 0.62)");
        }).focusout(function(e) {
            $(this).css("background-color", "#E66100");
        });

        $("#ordreQuestionQuiz").button().change(function() {
            if($(this).prop("checked") == true) {
                $(this).next("label").children("span").text("Fixe");
            }
            else {
                $(this).next("label").children("span").text("Aléatoire");
            }
        });

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

    });

</script>

<div id="sectionTitreQuiz">
    <input type="text" name="TitreQuiz" placeholder="Titre du quiz" id="titreQuiz" tabindex="1" value="<?php if($_SESSION['etat'] == "modifierQuiz") { echo $titreQuiz; } ?>">
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
    <input type="button" id="BTN_EnregistrerQuiz"  tabindex="5"
           <?php
           if($_SESSION['etat'] == 'modifierQuiz')
           {
               echo "value='Enregistrer' onclick='modifierQuiz(". $_SESSION['idQuiz']. ", \"".$_SESSION['idUsager'] ."\")' >";
           }
           else
           {
               echo "value='Ajouter' onclick='ajouterQuiz(\"".$_SESSION['idUsager'] ."\")' >";
           }
           ?>
    <input type="button" id="BTN_SupprimerQuiz" tabindex="6"
           <?php
            if($_SESSION['etat'] == 'modifierQuiz')
            {
                echo "value='Supprimer' onclick='supprimerQuiz(". $_SESSION['idQuiz']. ", \"". $_SESSION['idUsager'] ."\")' >";
            }
            else
            {
                echo "value='annuler' onclick='fermerDivDynamique()' >";
            }
           ?>

</div>