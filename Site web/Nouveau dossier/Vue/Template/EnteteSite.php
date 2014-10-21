<div id="enteteSite" class="fixed">
	<img class="logo" src="Vue/Images/Logo_QIz.png" alt="logo">
	<p id="nomSite"> QUIZINFO</p>
    <?php
    if (isset($_SESSION['idUsager'])){
        echo '<p id="NomUsager">'.$_SESSION['Nom'] . ' ' . $_SESSION['Prenom'] .'</p> <div id ="BTN_Deconnecter">Se Deconnecter</div> ';
    }?>
</div>
