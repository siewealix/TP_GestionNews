<?php
use App\Core\Flash;
use App\Core\Helpers;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Helpers::e($pageTitle ?? ($_ENV['APP_NAME'] ?? 'Gestion News')) ?></title>
    <link rel="stylesheet" href="<?= Helpers::asset('css/style.css') ?>">
</head>
<body>
<header class="site-header">
    <div class="container">
        <a class="logo" href="<?= Helpers::url('') ?>"><?= Helpers::e($_ENV['APP_NAME'] ?? 'Gestion News') ?></a>
        <nav>
            <a href="<?= Helpers::url('') ?>">Accueil</a>
            <a href="<?= Helpers::url('about') ?>">À propos</a>
            <a href="<?= Helpers::url('contact') ?>">Contact</a>
            <a href="<?= Helpers::url('admin') ?>">Admin</a>
        </nav>
        <form class="search" action="<?= Helpers::url('search') ?>" method="get">
            <input type="text" name="q" placeholder="Recherche...">
        </form>
    </div>
</header>
<main class="container">
    <?php if ($message = Flash::get('success')): ?>
        <div class="flash success"><?= Helpers::e($message) ?></div>
    <?php endif; ?>
    <?php if ($message = Flash::get('error')): ?>
        <div class="flash error"><?= Helpers::e($message) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>
<footer class="site-footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> <?= Helpers::e($_ENV['APP_NAME'] ?? 'Gestion News') ?></p>
    </div>
</footer>
</body>
</html>
