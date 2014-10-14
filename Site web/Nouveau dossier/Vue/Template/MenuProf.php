
<nav class="fixed">
	<a href='GererQuiz' class='NavBar'>Mes quiz et questions</a>
	<a href='../../GererCours.php' class='NavBar'>Mes cours</a>
    <a href='Statistiques' class='NavBar'>Statistiques</a>
    <a href="../../GererSonCompte.php" class="NavBar">Mon Compte</a>
    <?php
        // Ajout de l'onglet de menu Admin
        if(isset($_SESSION['TypeUsager']) && $_SESSION['TypeUsager'] == 'Admin') {
            echo "<a href='Admin' class='NavBar'>Administrateur</a>";
        }
    ?>
</nav>
