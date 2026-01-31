<?php
use App\Core\Auth;
use App\Core\Flash;
use App\Core\Helpers;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Helpers::e($pageTitle ?? 'Admin') ?></title>
    <link rel="stylesheet" href="<?= Helpers::asset('css/admin.css') ?>">
</head>
<body>
<header class="admin-header">
    <div class="container">
        <a class="logo" href="<?= Helpers::url('admin') ?>">Admin</a>
        <nav>
            <a href="<?= Helpers::url('admin/articles') ?>">Articles</a>
            <a href="<?= Helpers::url('admin/categories') ?>">Catégories</a>
            <a href="<?= Helpers::url('admin/tags') ?>">Tags</a>
            <a href="<?= Helpers::url('admin/users') ?>">Utilisateurs</a>
            <a href="<?= Helpers::url('admin/settings') ?>">Paramètres</a>
            <a href="<?= Helpers::url('logout') ?>">Déconnexion</a>
        </nav>
        <span class="user"><?= Helpers::e(Auth::user()['name'] ?? '') ?></span>
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
</body>
</html>
