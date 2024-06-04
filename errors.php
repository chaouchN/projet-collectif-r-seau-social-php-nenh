<?php

function queryError($error, $query) {
    echo "<article>";
    echo("Échec de la requete : " . $error);
    echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$query</code></p>");
    exit();
}

?>