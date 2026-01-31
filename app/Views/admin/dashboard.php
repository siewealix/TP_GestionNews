<?php
use App\Core\Helpers;
$pageTitle = 'Dashboard';
?>
<section>
    <h1>Dashboard</h1>
    <div class="stats">
        <div class="card">Articles publiés: <?= Helpers::e((string) $stats['published']) ?></div>
        <div class="card">Brouillons: <?= Helpers::e((string) $stats['drafts']) ?></div>
        <div class="card">Planifiés: <?= Helpers::e((string) $stats['scheduled']) ?></div>
    </div>

    <h2>Top catégories</h2>
    <ul>
        <?php foreach ($topCategories as $category): ?>
            <li><?= Helpers::e($category['name']) ?> (<?= Helpers::e((string) $category['total']) ?>)</li>
        <?php endforeach; ?>
    </ul>
</section>
