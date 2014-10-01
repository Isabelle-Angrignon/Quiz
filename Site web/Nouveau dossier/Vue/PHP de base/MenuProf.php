
<nav class="fixed">
	<a href='GererQuiz' class='NavBar'>Mes quiz et questions</a>
	<a href='Cours' class='NavBar'>Mes cours</a>
    <a href='Statistiques' class='NavBar'>Statistiques</a>
</nav>
<script>
$(function() {
    $("nav").load(function() {
        var nbElement = $("nav a").length();
        var format = 100/nbElement;
        $("nav a").each( function() {
            $(this).width(format + "%");
        });
    });
});
</script>
