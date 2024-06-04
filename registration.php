<?php 
require('connectionPdo.php');

require('header.php'); ?>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>
                    <?php
                    /**
                     * TRAITEMENT DU FORMULAIRE
                     */
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    
                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement)
                    {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                      
                        // et complétez le code ci dessous en remplaçant les ???
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];


                        //Etape 3 : Ouvrir une connexion avec la base de donnée.
                        $pdo = connect_bd();
                        //Etape 4 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $sql = "INSERT INTO users (email, password, alias) 
                        VALUES (:email, :password, :alias);";

                        $stmt = $pdo->prepare($sql);

                        // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                        $stmt->bindValue(':password', password_hash($_POST['motpasse'], PASSWORD_DEFAULT));
                        $stmt->bindValue(':alias', $_POST['pseudo'], PDO::PARAM_STR);
                        // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                        //Etape 5 : construction de la requete
                        $ok = $stmt->execute();
                        
                        // Etape 6: exécution de la requete
                        if ( ! $ok)
                        {
                            echo "L'inscription a échouée : " ;
                        } else
                        {
                            echo "Votre inscription est un succès : " . $_POST['pseudo'];
                            echo " <a href='login.php'>Connectez-vous.</a>";
                        }
                    }
                    ?>                     
                    <form action="registration.php" method="post">
                        <!-- <input type='hidden'name='???' value='achanger'> -->
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo'></dd>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse'></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
