<div id="bdp">
        <nav id="navbdp">
		<a href="APropos.php" class="NavBar">À propos</a>
		<a href="FAQ.php" class="NavBar">F.A.Q.</a>
        <a href="Developeur.php" class="NavBar">Développeur</a>
            <?php
            // Ajout de l'onglet de menu Admin
            if(isset($_SESSION['typeUsager']) && ($_SESSION['typeUsager'] == 'Prof' || $_SESSION['typeUsager'] == 'Admin')) {
                echo "<a href='https://docs.google.com/document/d/1F_JO7jholgO1Yg9DbdP0nlx3YrRiEFGJEE0jzbvhEqs/edit'
        class='NavBar' target='_blank'>Documentation</a>";
            }
            ?>

        </nav>
</div>
