<h2>export tabella da query</h2>
<?php

    echo "<form method=\"post\"  target=\"_blank\" name=\"datiUtenti\" action=\"export_statistiche.php?function=export_query\">";

    echo "<p>Inserisci la query da estrarre</p>";
    echo "<p>L'operazione potr&agrave; richiedere molti minuti</p>";
    echo "<p><textarea rows=\"4\" cols=\"50\"  name=\"query\"></textarea></p>";


    echo "<button type=\"submit\">invia</button></p>";
    echo "</form> ";

?>

