<?php

include 'connection.php';
require('header.php'); ?>
        <div id="wrapper">          
            <aside>
                <img src = <?php echo $user['photo_profil']?> alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?php echo $_SESSION["connected_id"] ?></p>

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
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                while ($post = $lesInformations->fetch_assoc())
                {
                    
            
                ?>
                <article>
                    <img src=<?php echo $user['photo_profil']?>alt="blason"/>
                    <h3><a href="wall.php?user_id=<?php echo $post['id'] ?>"><?php echo $post['alias']?></a></h3>
                    <p>id:<?php echo $post['id']?></p>
                </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
