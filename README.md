# Gestion News (PHP natif)

Plateforme de news modernisée en PHP natif avec un socle MVC léger, sécurisée et prête pour un usage local.

## Fonctionnalités
- Accueil avec articles paginés, mise en avant, dernières publications.
- Pages article avec tags, catégories, articles liés, compteur de vues (par session).
- Catégories, tags, recherche, RSS, sitemap.
- Page À propos + formulaire de contact.
- Admin complet : login/logout, dashboard, CRUD articles, catégories, tags, utilisateurs, paramètres.
- Sécurité : PDO préparé, CSRF, validation serveur, sessions, hash de mots de passe, RBAC.

## Prérequis
- PHP >= 8.1
- Extensions : pdo_mysql, mbstring, openssl (gd optionnelle pour thumbnails)
- MySQL/MariaDB
- Composer

## Installation
1. Copier le fichier d'environnement :
   ```bash
   cp .env.example .env
   ```
2. Créer la base et importer le schéma :
   ```bash
   mysql -u root -p gestion_news < sql/schema.sql
   ```
3. Charger les données de démo :
   ```bash
   mysql -u root -p gestion_news < sql/seed.sql
   ```
4. Installer les dépendances :
   ```bash
   composer install
   ```
5. Lancer le serveur :
   ```bash
   php -S localhost:8000 -t public
   ```

## Comptes de démo
- Admin : admin@example.com / admin123
- Éditeur : editor@example.com / editor123

## Structure
```
public/         # Front controller + assets
app/            # Core, Controllers, Models, Views
sql/            # schema.sql + seed.sql
storage/logs/   # logs applicatifs
legacy/         # ancien code
```

## Guide admin rapide
1. Connectez-vous via /login.
2. Créez un article dans **Articles**.
3. Définissez un statut publié et une date si nécessaire.
4. Gérez les catégories/tags et les utilisateurs.

## Sécurité et limitations
- Uploads filtrés par type MIME et taille.
- CSRF sur tous les formulaires POST.
- Session régénérée au login.
- Limitation simple du brute-force sur la page de login.

## Notes sur les choix
- Les messages de contact sont stockés en base (`contact_messages`).
- Les commentaires sont présents dans le schéma mais non exposés côté public (à activer selon besoin).
- Le RSS et le sitemap sont fournis via `/rss.xml` et `/sitemap.xml`.

## Docker (bonus)
Un `docker-compose.yml` est fourni pour PHP + MySQL.

```bash
docker-compose up -d
```

Le site est accessible sur http://localhost:8000.

## Nginx (note)
Configurer un bloc serveur avec `root public/` et réécriture vers `index.php`.
