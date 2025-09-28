<?php
class NewsManager {
    private $db;

    // Constructeur
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Méthode pour ajouter une news dans la base de données
    public function addNews(News $news) {
        $query = $this->db->prepare('INSERT INTO news (auteur, titre, contenu, dateAjout, dateModif) VALUES(:auteur, :titre, :contenu, NOW(), NOW())');

        $query->bindValue(':auteur', $news->getAuteur());
        $query->bindValue(':titre', $news->getTitre());
        $query->bindValue(':contenu', $news->getContenu());
        //$query->bindValue(':dateAjout', $news->getDateAjout());
        //$query->bindValue(':dateModif', $news->getDateModif());

        $query->execute();
    }

    // Méthode pour modifier une news dans la base de données
    public function updateNews(News $news) {
        $query = $this->db->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');

        $query->bindValue(':auteur', $news->getAuteur());
        $query->bindValue(':titre', $news->getTitre());
        $query->bindValue(':contenu', $news->getContenu());
       // $query->bindValue(':dateModif', $news->getDateModif());
        $query->bindValue(':id', $news->getId());

        $query->execute();
    }

    // Méthode pour supprimer une news de la base de données
    public function deleteNews($id) {
        $query = $this->db->prepare('DELETE FROM news WHERE id = :id');

        $query->bindValue(':id', $id);

        $query->execute();
    }

    /**
     * Récupère une news en fonction de son identifiant
     *
     * @param int $id L'identifiant de la news à récupérer
     * @return News|false La news correspondante, ou false si elle n'existe pas
     */
    public function getNewsById($id)
    {
        // On prépare la requête SQL
        $query = $this->db->prepare('SELECT * FROM news WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        // On exécute la requête
        $query->execute();

        // On récupère le résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // Si la requête a renvoyé un résultat, on crée une instance de News avec les données de la base de données
        if ($result !== false) {
            return new News($result['id'], $result['auteur'], $result['titre'], $result['contenu'], $result['dateAjout'], $result['dateModif']);
        } else {
            return false;
        }
    }

    /**
     * Récupère les cinq dernières news ajoutées à la base de données
    */
    public function getLatestNews()
    {
        // On prépare la requête SQL
        $query = $this->db->query('SELECT * FROM news ORDER BY dateAjout DESC LIMIT 5');

        // On récupère le résultat de la requête
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // On crée un tableau d'instances de News avec les données de la base de données
        $newsList = array();
        foreach ($results as $result) {
            $newsList[] = new News($result['id'], $result['auteur'], $result['titre'], $result['contenu'], $result['dateAjout'], $result['dateModif']);
        }

        return $newsList;
    }

    public function getAllNews()
{
     // On prépare la requête SQL
     $query = $this->db->query('SELECT * FROM news ORDER BY dateAjout DESC ');

     // On récupère le résultat de la requête
     $results = $query->fetchAll(PDO::FETCH_ASSOC);

     // On crée un tableau d'instances de News avec les données de la base de données
     $newsList = array();
     foreach ($results as $result) {
         $newsList[] = new News($result['id'], $result['auteur'], $result['titre'], $result['contenu'], $result['dateAjout'], $result['dateModif']);
     }

     return $newsList;
}




}

$db = new PDO('mysql:host=localhost;dbname=news_db', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$newsManager = new NewsManager($db);


?>