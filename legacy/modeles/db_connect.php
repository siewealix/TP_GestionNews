<?php
// informations de connexion à la base de données
$host = 'localhost'; // nom d'hôte
$user = 'root'; // nom d'utilisateur
$password = ''; // mot de passe
$db_name = 'news_db'; // nom de la base de données

// connexion à la base de données avec l'extension PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    // configuration des options de PDO pour afficher les erreurs SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>