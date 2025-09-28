<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles/index_design.css">
    
    <style> h1{   color : black;    font-weight: bolder;  } </style>    
    
</head>
<body>
    <div class="container">
        <h1>Dernières actualités</h1>
        <?php
        // Inclusion des classes et de la connexion à la base de données
        require_once('../controleurs/News.php');
        require_once('../modeles/NewsManager.php');
        require_once('../modeles/db_connect.php');

        // Création d'une instance de NewsManager
        $manager = new NewsManager($db);

        // Récupération des cinq dernières news
        $latestNews = $manager->getLatestNews();

        // Affichage de chaque news
        foreach ($latestNews as $news) {
            echo '<div class="news">';
            echo '<h2><a href="details_news.php?id='.$news->getId().'">'.$news->getTitre().'</a></h2>';
            echo '<p class="date published">Publiée par '.$news->getAuteur().' le '.$news->getDateAjout().'</p>';            
            if ($news->getDateAjout() != $news->getDateModif()) {
                echo '<p class="date modified">Modifiée le '.$news->getDateModif().'</p>';
            }
            echo '<br>';
            echo '<p class="content">'.substr($news->getContenu(), 0, 200).'...</p>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>





