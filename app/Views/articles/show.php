<?php
use App\Core\Helpers;
$pageTitle = $article['title'];
?>
<article class="article">
    <h1><?= Helpers::e($article['title']) ?></h1>
    <p class="meta">Par <?= Helpers::e($article['author_name']) ?> · <?= Helpers::e(Helpers::formatDate($article['published_at'])) ?></p>
    <img src="<?= Helpers::e(Helpers::url($article['cover_image'] ?? 'assets/img/placeholder.svg')) ?>" alt="">
    <div class="content"><?= nl2br(Helpers::e($article['content'])) ?></div>
    <p>Catégorie : <a href="<?= Helpers::url('categorie/' . $article['category_slug']) ?>"><?= Helpers::e($article['category_name']) ?></a></p>
    <p>Tags:
        <?php foreach ($tags as $tag): ?>
            <a href="<?= Helpers::url('tag/' . $tag['slug']) ?>">#<?= Helpers::e($tag['name']) ?></a>
        <?php endforeach; ?>
    </p>
</article>

<?php if ($related): ?>
    <section>
        <h2>Articles liés</h2>
        <ul>
            <?php foreach ($related as $item): ?>
                <li><a href="<?= Helpers::url('article/' . $item['slug']) ?>"><?= Helpers::e($item['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
