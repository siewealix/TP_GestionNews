<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Articles';
?>
<section>
    <h1>Articles</h1>
    <a class="button" href="<?= Helpers::url('admin/articles/create') ?>">Nouvel article</a>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= Helpers::e($article['title']) ?></td>
                    <td><?= Helpers::e($article['category_name']) ?></td>
                    <td><?= Helpers::e($article['status']) ?></td>
                    <td>
                        <a href="<?= Helpers::url('admin/articles/' . $article['id'] . '/edit') ?>">Éditer</a>
                        <form method="post" action="<?= Helpers::url('admin/articles/' . $article['id'] . '/delete') ?>" style="display:inline">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
