
<nav class="fixed">
	<a href='../../Prof-GererQuiz.php' class='NavBar'>Mes quiz et questions</a>
	<a href='../../GererCours.php' class='NavBar'>Mes cours</a>
    <a href='#' class='NavBar' id="notImplement">Statistiques</a>
    <a href="../../GererSonCompte.php" class="NavBar">Mon Compte</a>
    <?php
        // Ajout de l'onglet de menu Admin
        if(isset($_SESSION['TypeUsager']) && $_SESSION['TypeUsager'] == 'Admin') {
            echo "<a href='Admin' class='NavBar'>Administrateur</a>";
        }
    ?>
</nav>

<script>$("#notImplement").click(function(){swal("Désolé","Les statisitques ne sont pas encore implémenter","error");});</script>
