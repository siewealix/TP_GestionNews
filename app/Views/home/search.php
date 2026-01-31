<?php
use App\Core\Helpers;
$pageTitle = 'Recherche';
?>
<section>
    <h1>Recherche</h1>
    <?php if ($query): ?>
        <p>Résultats pour "<?= Helpers::e($query) ?>"</p>
    <?php endif; ?>

    <div class="grid">
        <?php foreach ($articles as $article): ?>
            <article class="card">
                <img src="<?= Helpers::e(Helpers::url($article['cover_image'] ?? 'assets/img/placeholder.svg')) ?>" alt="">
                <h3><a href="<?= Helpers::url('article/' . $article['slug']) ?>"><?= Helpers::e($article['title']) ?></a></h3>
                <p><?= Helpers::e($article['excerpt']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($paginator->totalPages() > 1): ?>
        <nav class="pagination">
            <?php for ($i = 1; $i <= $paginator->totalPages(); $i++): ?>
                <a class="<?= $i === $paginator->page ? 'active' : '' ?>" href="<?= Helpers::url('search?q=' . urlencode($query) . '&page=' . $i) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>
