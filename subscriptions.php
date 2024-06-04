<?php

include 'connection.php';
require('header.php');
require ('photoPath.php');
$userId = intval($_GET['user_id']);
$userIndex = $userId - 1;
$userPhotoPath = '"' . $photoPathArray[$userIndex][1] . '"';
?>
        <div id="wrapper">
            <aside>
                <img src=<?php echo $userPhotoPath?> alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo $_SESSION["connected_id"] ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = $_SESSION["connected_id"];
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                while ($post = $lesInformations->fetch_assoc())
                {

                    $userIndex = $post['id'] - 1;
                    $userPhotoPath = '"' . $photoPathArray[$userIndex][1] . '"';
               
               ?> 
                <article>
                    <img src=<?php echo $userPhotoPath?> alt="blason"/>
                    <h3><a href="wall.php?user_id=<?php echo $post['id'] ?>"><?php echo $post['alias']?></a></h3>
                    <p>id:<?php echo $post['id']?></p>                    
                </article>
               <?php } ?>
            </main>
        </div>
    </body>
</html>
