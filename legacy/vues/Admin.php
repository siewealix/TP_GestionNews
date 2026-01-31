<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style> body{ font-family: cursive;} </style>
</head>
<body>
<?php

    // Inclusion des classes et de la connexion à la base de données
    require_once('../controleurs/News.php');
    require_once('../modeles/NewsManager.php');
    require_once('../modeles/db_connect.php');
    
    

    // Création d'une instance de NewsManager
    $manager = new NewsManager($db);
    
    // Si le formulaire a été soumis pour ajouter ou modifier une news
    if (isset($_POST['submit'])) {
        
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $contenu = $_POST['contenu'];
        
    
        // Si l'identifiant de la news est renseigné, on modifie la news
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $news = new News(null, $auteur, $titre, $contenu, null, null); // création d'une instance de News avec les nouvelles données
            $news->setId($id); // set l'id de la news
            $manager->updateNews($news); // mise à jour de la news dans la base de données
            // Message de succès après la modification
            echo '<div class="alert alert-success" role="alert">La news a été modifiée avec succès !</div>';

            //reinitialiser les champs du formulaire
            $titre = '';
            $auteur = '';
            $contenu = '';
        }
        // Sinon, on ajoute une nouvelle news
        else {
            $news = new News(null, $auteur, $titre, $contenu, null, null); // création d'une instance de News avec les données du formulaire
            $manager->addNews($news); // ajout de la news dans la base de données
            // Message de succès après l'ajout
            echo '<div class="alert alert-success" role="alert">La news a été ajoutée avec succès !</div>';

            //reinitialiser les champs du formulaire
            $titre = '';
            $auteur = '';
            $contenu = '';
        }
    }
    
    // Si l'identifiant d'une news est renseigné pour la modifier ou la supprimer
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];
    
        // Si on souhaite modifier une news, on pré-remplit le formulaire avec ses informations
        if ($action == 'edit') {
            $news = $manager->getNewsById($id);
            $titre = $news->getTitre();
            $auteur = $news->getAuteur();
            $contenu = $news->getContenu();
        }
        // Sinon, on supprime la news correspondante
        else if ($action == 'delete') {
            $manager->deleteNews($id);
            // Message de succès après la suppression
        echo '<div class="alert alert-success" role="alert">La news a été supprimée avec succès !</div>';

        
        }
    }
    
    
    
    

// Récupération de toutes les news
$allNews = $manager->getAllNews();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
<h1>Gestion de news</h1>
<!-- Formulaire pour ajouter ou modifier une news -->
<form method="POST" action="Admin.php">
    <?php
    // Si on modifie une news, on ajoute un champ caché pour stocker son identifiant
    if (isset($id)) {
        echo '<input type="hidden" name="id" value="'.$id.'">';
    }
    ?>
    <div class="form-group">
        <label for="titre"></label>
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo isset($titre) ? $titre : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="auteur"></label>
        <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Auteur" value="<?php echo isset($auteur) ? $auteur : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="contenu"></label>
        <textarea class="form-control" id="contenu" name="contenu" placeholder="Contenu"  rows="5" required><?php echo isset($contenu) ? $contenu : ''; ?></textarea>
    </div>
    <br>
    <button type="submit" name="submit" class="btn btn-primary"><?php if (isset($id)) echo 'Modifier'; else echo 'Ajouter'; ?> la news</button>
</form>
<br>
<br>
<h2>Liste des news</h2>
<table class="table table-striped">
 <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Date d'ajout</th>
        <th>Date de modification</th>
        <th>Actions</th>
    </tr>
  </thead>
  <tbody>
<?php
// Récupération de toutes les news
$allNews = $manager->getAllNews();

// Affichage de chaque news dans le tableau
foreach ($allNews as $news) {
    echo '<tr>';
    echo '<td>'.$news->getId().'</td>';
    echo '<td>'.$news->getTitre().'</td>';
    echo '<td>'.$news->getAuteur().'</td>';
    echo '<td>'.$news->getDateAjout().'</td>';
    echo '<td>'.$news->getDateModif().'</td>';
    echo '<td>';
    echo '<a href="?action=edit&id='.$news->getId().'">Modifier</a> | ';
    echo '<a href="?action=delete&id='.$news->getId().'">Supprimer</a>';
    echo '</td>';
    echo '</tr>';
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!-- Ajout du CDN de Bootstrap 5 pour les scripts Javascript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>>
    
</body>
</html>