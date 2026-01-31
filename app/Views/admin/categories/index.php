<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Catégories';
?>
<section>
    <h1>Catégories</h1>
    <form method="post" action="<?= Helpers::url('admin/categories') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <input type="text" name="name" placeholder="Nom de catégorie" required>
        <button type="submit">Ajouter</button>
    </form>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <?= Helpers::e($category['name']) ?>
                <form method="post" action="<?= Helpers::url('admin/categories/' . $category['id'] . '/delete') ?>" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
