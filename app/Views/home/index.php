<?php
use App\Core\Helpers;
$pageTitle = 'Accueil';
?>
<section class="hero">
    <h1>Dernières actualités</h1>
</section>

<?php if ($featured): ?>
    <section class="featured">
        <h2>À la une</h2>
        <article>
            <img src="<?= Helpers::e(Helpers::url($featured['cover_image'] ?? 'assets/img/placeholder.svg')) ?>" alt="">
            <div>
                <h3><a href="<?= Helpers::url('article/' . $featured['slug']) ?>"><?= Helpers::e($featured['title']) ?></a></h3>
                <p><?= Helpers::e($featured['excerpt']) ?></p>
            </div>
        </article>
    </section>
<?php endif; ?>

<section>
    <h2>Articles récents</h2>
    <div class="grid">
        <?php foreach ($articles as $article): ?>
            <article class="card">
                <img src="<?= Helpers::e(Helpers::url($article['cover_image'] ?? 'assets/img/placeholder.svg')) ?>" alt="">
                <h3><a href="<?= Helpers::url('article/' . $article['slug']) ?>"><?= Helpers::e($article['title']) ?></a></h3>
                <p><?= Helpers::e($article['excerpt']) ?></p>
                <span><?= Helpers::e($article['category_name']) ?> · <?= Helpers::e(Helpers::formatDate($article['published_at'])) ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php if ($paginator->totalPages() > 1): ?>
    <nav class="pagination">
        <?php for ($i = 1; $i <= $paginator->totalPages(); $i++): ?>
            <a class="<?= $i === $paginator->page ? 'active' : '' ?>" href="<?= Helpers::url('?page=' . $i) ?>"><?= $i ?></a>
        <?php endfor; ?>
    </nav>
<?php endif; ?>
