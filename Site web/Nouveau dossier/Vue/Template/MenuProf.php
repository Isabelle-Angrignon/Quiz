
<nav class="fixed">
	<a href='GererQuiz' class='NavBar'>Mes quiz et questions</a>
	<a href='Cours' class='NavBar'>Mes cours</a>
    <a href='Statistiques' class='NavBar'>Statistiques</a>
    <?php
        // Ajout de l'onglet de menu Admin
        if(isset($_SESSION['TypeUsager']) && $_SESSION['TypeUsager'] == 'Admin') {
            echo "<a href='Admin' class='NavBar'>Administrateur</a>";
        }
    ?>
</nav>
