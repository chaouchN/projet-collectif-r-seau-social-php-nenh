<!doctype html>
<?php
session_start();
if (isset($_GET['deconnexion']) && $_GET['deconnexion']=='1'){
    
    session_destroy();
    header("Location:http://resoc.localhost/news.php");
}
if (!isset($_SESSION["connected_id"])){
$userid=1;
}else{
    $userid = $_SESSION["connected_id"];
   
}?>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Racoonection</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
        <?php if (isset($_SESSION["connected_id"])){ ?>
            <a href='admin.php'><img src="photo_profil/raton_laveur.jpg" alt="Logo de notre réseau social"/></a>
            <?php }else{ ?>
                <img src="photo_profil/raton_laveur.jpg" alt="Logo de notre réseau social"/><?php } ?>
        
            <!-- <a href='admin.php'><img src="fouine.jpg" alt="Logo de notre réseau social"/></a> -->
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <?php if (isset($_SESSION["connected_id"])){?>
                <a href="wall.php?<?php echo $userid ?>">Mur</a>
                <a href="feed.php?<?php echo $userid ?>">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
                <?php }?>
            </nav>
            <nav id="user">
            <?php if (isset($_SESSION["connected_id"])){?>
                <a href="settings.php?<?php $userid ?>">▾ Profil</a>
                <ul>
                    <li><a href="settings.php?<?php echo $userid ?>">Paramètres</a></li>
                    <li><a href="followers.php?<?php echo $userid ?>">Mes fouines</a></li>
                    <li><a href="subscriptions.php?<?php echo $userid ?>">Mes abonnements</a></li>
                    <?php if (isset($_SESSION["connected_id"])){?>
                    <li><a href="news.php?deconnexion=1">Me déconnecter</a></li><?php }else{?>
                     <li><a href="login.php?">Me Connecter</a></li><?php }   ?>
                </ul>
                <?php }else{?>
                  <a href="login.php?">Me Connecter</a><?php }   ?>  
            </nav>
        </header>