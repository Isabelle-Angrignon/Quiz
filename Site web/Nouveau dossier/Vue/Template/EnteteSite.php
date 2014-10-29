<div id="enteteSite" class="fixed">
	<a href="index.php"><img class="logo" src="Vue/Images/Logo_QIz.png" alt="logo" ></a>
    <a href="index.php"><p id="nomSite"> QUIZINFO</p></a>
    <form id="EspaceDeconnexion" method="post" action="controleur/seDeconnecter.php">
    <?php
    if (isset($_SESSION['idUsager'])){
        echo '<div id="NomUsager">'.$_SESSION['Nom'] . ', ' . $_SESSION['Prenom'] .'</div> <div id ="BTN_Deconnecter">Se déconnecter</div> ';
    }?>
    </form>
</div>

<script>
    $('#BTN_Deconnecter').click(function(){
        $('#EspaceDeconnexion').submit();
    });
</script>
