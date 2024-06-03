<?php 
$photoPathQuery = "
    SELECT
        users.id,
        users.photo_profil
    FROM
        users
    ORDER BY
        users.id
";

$photoPathAnswer = $mysqli->query($photoPathQuery);

if ( ! $photoPathAnswer)
{
    echo("Échec de la requete : " . $mysqli->error);
    exit();
}

$photoPathArray = $photoPathAnswer->fetch_all();
for($i = 0; $i < count($photoPathArray); $i++) {
    if ( ! $photoPathArray[$i][1]) {
        $photoPathArray[$i][1] = 'user.jpg';
    }
}
?>