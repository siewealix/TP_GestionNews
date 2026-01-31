<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Éditer un article';
?>
<section>
    <h1>Éditer un article</h1>
    <form method="post" action="<?= Helpers::url('admin/articles/' . $article['id'] . '/update') ?>" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <label>Titre
            <input type="text" name="title" value="<?= Helpers::e($article['title']) ?>" required>
        </label>
        <label>Extrait
            <textarea name="excerpt" rows="3"><?= Helpers::e($article['excerpt']) ?></textarea>
        </label>
        <label>Contenu
            <textarea name="content" rows="10" required><?= Helpers::e($article['content']) ?></textarea>
        </label>
        <label>Image de couverture
            <input type="file" name="cover_image" accept="image/*">
        </label>
        <label>Catégorie
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] === $article['category_id'] ? 'selected' : '' ?>><?= Helpers::e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Tags
            <select name="tags[]" multiple>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $selectedTags, true) ? 'selected' : '' ?>><?= Helpers::e($tag['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Statut
            <select name="status">
                <option value="draft" <?= $article['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                <option value="published" <?= $article['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                <option value="scheduled" <?= $article['status'] === 'scheduled' ? 'selected' : '' ?>>Planifié</option>
            </select>
        </label>
        <label>Publication
            <input type="datetime-local" name="published_at" value="<?= $article['published_at'] ? date('Y-m-d\TH:i', strtotime($article['published_at'])) : '' ?>">
        </label>
        <label>
            <input type="checkbox" name="featured" value="1" <?= $article['featured'] ? 'checked' : '' ?>> À la une
        </label>
        <button type="submit">Mettre à jour</button>
    </form>
</section>
