<?php 
include 'connection.php';
if (isset($_GET['deconnexion']) && $_GET['deconnexion']=='1'){
    
    session_destroy();
}
require('header.php'); ?>
        <div id="wrapper">
            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages de
                        tous les utilisatrices du site.</p>
                </section>
            </aside>
            <main>
               
                <?php
                /*
                  // C'est ici que le travail PHP commence
                  // Votre mission si vous l'acceptez est de chercher dans la base
                  // de données la liste des 5 derniers messsages (posts) et
                  // de l'afficher
                  // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
                  // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
                 */

                // Etape 1: Ouvrir une connexion avec la base de donnée.
               

                // Etape 2: Poser une question à la base de donnée et récupérer ses informations
                // cette requete vous est donnée, elle est complexe mais correcte, 
                // si vous ne la comprenez pas c'est normal, passez, on y reviendra
                $laQuestionEnSql = "
                    SELECT 
                        posts.content,
                        GROUP_CONCAT(DISTINCT posts_tags.tag_id) AS tag_ids,
                        posts.created,
                        posts.user_id,
                        users.alias AS author_name,
                        COUNT(likes.id) AS like_number,
                        GROUP_CONCAT(DISTINCT tags.label) AS taglist
                    FROM 
                        posts
                    JOIN 
                        users ON users.id = posts.user_id
                    LEFT JOIN 
                        posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN 
                        tags ON posts_tags.tag_id = tags.id
                    LEFT JOIN 
                        likes ON likes.post_id = posts.id
                    GROUP BY 
                        posts.id
                    ORDER BY 
                        posts.created DESC
                    LIMIT 5;
                ";
            
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification

                $laQuestionEnSql = "SELECT id, label FROM tags ORDER BY id";
                $lesInfoDesTags = $mysqli->query($laQuestionEnSql);
                $tags = $lesInfoDesTags->fetch_all();

                // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
                // NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                while ($post = $lesInformations->fetch_assoc())
                {
                    $our_ids = explode(',', $post['tag_ids']);
                    $our_tags = explode(',', $post['taglist']);
                    ?>
                    <article>
                        <h3>
                            <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name']?></a></address>
                        <div>
                            <p><?php echo $post['content']?></p>
                        </div>
                        <footer>
                            <small>🦝<?php echo $post['like_number']?></small>
                    <?php
                    for ($i = 0; $i < count($our_ids); $i++) {
                        $labelIndex = $our_ids[$i] - 1;
                        $tag = $tags[$labelIndex];
                        echo <<<HTML
                            <a href="tags.php?tag_id=$our_ids[$i]">#$tag[1]</a>
                        HTML;
                    }
                    ?>
                        </footer>
                    </article>
                    <?php
                    // avec le <?php ci-dessus on retourne en mode php 
                }// cette accolade ferme et termine la boucle while ouverte avant.
                ?>

            </main>
        </div>
    </body>
</html>