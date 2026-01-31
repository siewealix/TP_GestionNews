<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details News</title>
    <link rel="stylesheet" href="styles/Detail_design.css">
</head>
<body>
<?php
// Inclusion des classes et de la connexion à la base de données
require_once('../controleurs/News.php');
require_once('../modeles/NewsManager.php');
require_once('../modeles/db_connect.php');

// Récupération de la news en fonction de son identifiant
if (isset($_GET['id'])) {
    $manager = new NewsManager($pdo);
    $news = $manager->getNewsById($_GET['id']);
}

// Affichage de la news
if (isset($news)) {
    echo '<div class="news-container">';
    echo '<h2>' . $news->getTitre() . '</h2>';
    echo '<p class="date published">Par ' . $news->getAuteur() . ', le ' . $news->getDateAjout() . '</p>';
    if ($news->getDateAjout() != $news->getDateModif()) {
        echo '<p class="date modified">Modifiée le '.$news->getDateModif().'</p>';
    }
    echo '<div class="news-content"><p>' . $news->getContenu() . '</p></div>';
    echo '</div>';
} else {
    echo '<p>Cette news n\'existe pas.</p>';
}
?>

</body>
</html>