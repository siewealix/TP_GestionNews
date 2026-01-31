INSERT INTO users (name, email, password_hash, role, created_at) VALUES
('Admin', 'admin@example.com', '$2y$12$/mQW9NLj.IRr.T9MjcmF1eowsucHrBdWanFmNyEtZpIYsHyVHf.02', 'admin', NOW()),
('Editeur', 'editor@example.com', '$2y$12$/saD2DaDUL354.ug.f8RJ.P8FQWveOek4HRHoriUCpxXsrn01HmtC', 'editor', NOW());

INSERT INTO categories (name, slug, created_at) VALUES
('Tech', 'tech', NOW()),
('Business', 'business', NOW()),
('Culture', 'culture', NOW()),
('Sport', 'sport', NOW()),
('Lifestyle', 'lifestyle', NOW());

INSERT INTO tags (name, slug) VALUES
('PHP', 'php'),
('Sécurité', 'securite'),
('Design', 'design'),
('Startup', 'startup'),
('Data', 'data'),
('IA', 'ia'),
('Web', 'web'),
('Mobile', 'mobile'),
('SEO', 'seo'),
('Cloud', 'cloud');

INSERT INTO articles (title, slug, excerpt, content, cover_image, category_id, author_id, status, featured, published_at, views, created_at, updated_at) VALUES
('Moderniser une base PHP', 'moderniser-une-base-php', 'Conseils pour refondre un legacy PHP.', 'Contenu détaillé sur la modernisation.', NULL, 1, 1, 'published', 1, NOW(), 10, NOW(), NOW()),
('Sécurité des formulaires', 'securite-des-formulaires', 'CSRF, validation et sécurité.', 'Bonnes pratiques pour sécuriser.', NULL, 1, 1, 'published', 0, NOW(), 4, NOW(), NOW()),
('Tendances business 2024', 'tendances-business-2024', 'Analyse des tendances.', 'Un aperçu des tendances.', NULL, 2, 2, 'published', 0, NOW(), 6, NOW(), NOW()),
('Créer une culture produit', 'creer-une-culture-produit', 'Mettre l utilisateur au centre.', 'Culture produit et organisation.', NULL, 3, 2, 'published', 0, NOW(), 2, NOW(), NOW()),
('Préparer un marathon', 'preparer-un-marathon', 'Programme sur 12 semaines.', 'Plan d entrainement détaillé.', NULL, 4, 2, 'published', 0, NOW(), 1, NOW(), NOW()),
('Bien-être au travail', 'bien-etre-au-travail', 'Rituels pour la sérénité.', 'Conseils santé mentale.', NULL, 5, 2, 'published', 0, NOW(), 3, NOW(), NOW()),
('Nouveau framework JS', 'nouveau-framework-js', 'Analyse d un nouveau framework.', 'Points forts et faiblesses.', NULL, 1, 1, 'draft', 0, NULL, 0, NOW(), NOW()),
('Optimiser le SEO local', 'optimiser-le-seo-local', 'Guide SEO pour PME.', 'Checklist SEO local.', NULL, 2, 1, 'published', 0, NOW(), 5, NOW(), NOW()),
('Design system maison', 'design-system-maison', 'Créer un design system.', 'Exemples de composants.', NULL, 3, 1, 'published', 0, NOW(), 2, NOW(), NOW()),
('Analyse des données sportives', 'analyse-des-donnees-sportives', 'L analytics au service du sport.', 'Cas pratiques.', NULL, 4, 1, 'published', 0, NOW(), 1, NOW(), NOW()),
('Cuisine saine rapide', 'cuisine-saine-rapide', 'Recettes rapides.', 'Idées repas.', NULL, 5, 2, 'published', 0, NOW(), 2, NOW(), NOW()),
('API REST en PHP', 'api-rest-en-php', 'Structurer une API.', 'Exemples de routes.', NULL, 1, 1, 'published', 0, NOW(), 1, NOW(), NOW()),
('Cloud pour les PME', 'cloud-pour-les-pme', 'Choisir un cloud.', 'Comparatif rapide.', NULL, 2, 2, 'published', 0, NOW(), 2, NOW(), NOW()),
('Expérience mobile', 'experience-mobile', 'Optimiser le mobile.', 'Points clés UX.', NULL, 3, 2, 'draft', 0, NULL, 0, NOW(), NOW()),
('IA dans la rédaction', 'ia-dans-la-redaction', 'Automatiser des contenus.', 'Risques et bénéfices.', NULL, 1, 1, 'published', 0, NOW(), 3, NOW(), NOW()),
('Gestion du stress', 'gestion-du-stress', 'Techniques simples.', 'Respiration et cohérence.', NULL, 5, 2, 'published', 0, NOW(), 1, NOW(), NOW()),
('Compétition locale', 'competition-locale', 'Retour sur l évènement.', 'Les meilleurs moments.', NULL, 4, 2, 'published', 0, NOW(), 1, NOW(), NOW()),
('Nouveaux outils product', 'nouveaux-outils-product', 'Stack product moderne.', 'Outils à tester.', NULL, 2, 1, 'published', 0, NOW(), 2, NOW(), NOW()),
('Veille web moderne', 'veille-web-moderne', 'Organiser sa veille.', 'Routines efficaces.', NULL, 1, 2, 'published', 0, NOW(), 1, NOW(), NOW()),
('Cuisine anti-gaspi', 'cuisine-anti-gaspi', 'Recettes anti-gaspi.', 'Réutiliser les restes.', NULL, 5, 2, 'published', 0, NOW(), 1, NOW(), NOW());

INSERT INTO article_tags (article_id, tag_id) VALUES
(1, 1), (1, 2),
(2, 2), (2, 7),
(3, 4), (3, 5),
(4, 3), (4, 7),
(5, 5),
(6, 9),
(8, 9),
(9, 3),
(10, 5),
(11, 7),
(12, 1),
(13, 10),
(15, 6),
(16, 2),
(18, 4),
(19, 7),
(20, 9);

INSERT INTO comments (article_id, name, email, content, status, created_at) VALUES
(1, 'Alice', 'alice@example.com', 'Article très utile !', 'approved', NOW()),
(1, 'Bob', 'bob@example.com', 'Merci pour les conseils.', 'approved', NOW());

INSERT INTO settings (`key`, `value`) VALUES
('site_name', 'Gestion News'),
('contact_email', 'contact@example.com'),
('pagination_per_page', '6');
