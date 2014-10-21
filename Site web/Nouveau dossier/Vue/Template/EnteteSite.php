<div id="enteteSite" class="fixed">
	<img class="logo" src="Vue/Images/Logo_QIz.png" alt="logo">
	<p id="nomSite"> QUIZINFO</p>
    <form id="EspaceDeconnexion" method="post" action="controleur/seDeconnecter.php">
    <?php
    if (isset($_SESSION['idUsager'])){
        echo '<div id="NomUsager">'.$_SESSION['Nom'] . ' ' . $_SESSION['Prenom'] .'</div> <div id ="BTN_Deconnecter">Se Deconnecter</div> ';
    }?>
    </form>
</div>

<script>
    $('#BTN_Deconnecter').click(function(){
        $('#EspaceDeconnexion').submit();
    });
</script>
