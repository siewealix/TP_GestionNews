<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Tags';
?>
<section>
    <h1>Tags</h1>
    <form method="post" action="<?= Helpers::url('admin/tags') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <input type="text" name="name" placeholder="Nom du tag" required>
        <button type="submit">Ajouter</button>
    </form>
    <ul>
        <?php foreach ($tags as $tag): ?>
            <li>
                <?= Helpers::e($tag['name']) ?>
                <form method="post" action="<?= Helpers::url('admin/tags/' . $tag['id'] . '/delete') ?>" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
