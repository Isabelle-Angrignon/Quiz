<?php
//MenuProf.php
// A inclure lorsque cette un étudiant est connecter. Ce fichier générera le menu de l'étudiant
?>

<nav class="fixed">
	<a href='Prof-GererQuiz.php' class='NavBar'>Mes quiz et questions</a>
	<a href='GererCours.php' class='NavBar'>Mes cours</a>
    <a href="GererSonCompte.php" class="NavBar">Mon Compte</a>
    <a href='#' class='NavBar' id="stats">Statistiques</a>
    <?php
        // Ajout de l'onglet de menu Admin
        if(isset($_SESSION['typeUsager']) && $_SESSION['typeUsager'] == 'Admin') {
            echo "<a href='Admin.php' class='NavBar'>Administrateur</a>";
        }
    ?>
</nav>

<script>
    $("#stats").click(function(){swal({   title: "Êtes-vous sur?",
        text: "Voulez vous télécharger un .csv contenant les statistiques ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FFA64F",
        confirmButtonText: "Télécharger",
        closeOnConfirm:true
    }, function(){
        window.location.assign("Controleur/ListerStats.php");
    });
    });

</script>
