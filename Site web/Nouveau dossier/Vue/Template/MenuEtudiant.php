<nav class="fixed">
	<a href='Etudiant-Accueil.php' class='NavBar'>Mes quiz</a>
	<a href='GererSonCompte.php' class='NavBar'>Mon profil</a>
	<a href='#' class='NavBar' id="notImplement">Mes stats</a>
</nav>
<script>
    $("#notImplement").click(
        function(){
            swal("Désolé","Les statistiques ne sont pas encore implémentées","error");
        });
</script>