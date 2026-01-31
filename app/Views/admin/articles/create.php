<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Créer un article';
?>
<section>
    <h1>Créer un article</h1>
    <form method="post" action="<?= Helpers::url('admin/articles') ?>" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <label>Titre
            <input type="text" name="title" required>
        </label>
        <label>Extrait
            <textarea name="excerpt" rows="3"></textarea>
        </label>
        <label>Contenu
            <textarea name="content" rows="10" required></textarea>
        </label>
        <label>Image de couverture
            <input type="file" name="cover_image" accept="image/*">
        </label>
        <label>Catégorie
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= Helpers::e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Tags
            <select name="tags[]" multiple>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag['id'] ?>"><?= Helpers::e($tag['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Statut
            <select name="status">
                <option value="draft">Brouillon</option>
                <option value="published">Publié</option>
                <option value="scheduled">Planifié</option>
            </select>
        </label>
        <label>Publication
            <input type="datetime-local" name="published_at">
        </label>
        <label>
            <input type="checkbox" name="featured" value="1"> À la une
        </label>
        <button type="submit">Enregistrer</button>
    </form>
</section>
