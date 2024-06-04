<?php


include 'connection.php';
require('header.php'); 
require('photoPath.php');
?>
        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            
            $userId = $_SESSION["connected_id"];
            ?>
            <?php
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                if ( ! $user['photo_profil']) {
                    $user['photo_profil'] = 'user.jpg';
                }
               
                ?>
                <img src=<?php echo $user['photo_profil']?> alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice <a href="wall.php?user_id=<?php echo $userId ?>"><?php echo $user['alias'] ?></a>
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT 
                        posts.content, 
                        posts.created, 
                        users.alias as author_name, 
                        posts.user_id,
                        GROUP_CONCAT(DISTINCT posts_tags.tag_id) AS tag_ids,
                        COUNT(likes.id) as like_number, 
                        GROUP_CONCAT(DISTINCT tags.label) AS taglist
                    FROM 
                        posts
                    JOIN 
                        users ON  users.id=posts.user_id
                    LEFT JOIN 
                        posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN 
                        tags ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN 
                        likes ON likes.post_id  = posts.id 
                    WHERE 
                        posts.user_id='$userId' 
                    GROUP BY 
                        posts.id
                    ORDER BY 
                        posts.created DESC  
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
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created']?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['user_id']?>"><?php echo $post['author_name']?></a></address>
                        <div>
                            <p><?php echo $post['content']?></p>
                            
                        </div>                                            
                        <footer>
                            <small>🦝 <?php echo $post['like_number']?></small>
                            <a href="tags.php?tag_id=<?php echo $post['tag_ids'] ?>">#<?php echo $post['taglist']?></a>
                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
