<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Paramètres';
?>
<section>
    <h1>Paramètres</h1>
    <form method="post" action="<?= Helpers::url('admin/settings') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <label>Nom du site
            <input type="text" name="site_name" value="<?= Helpers::e($settings['site_name'] ?? ($_ENV['APP_NAME'] ?? 'Gestion News')) ?>">
        </label>
        <label>Email de contact
            <input type="email" name="contact_email" value="<?= Helpers::e($settings['contact_email'] ?? ($_ENV['CONTACT_EMAIL'] ?? '')) ?>">
        </label>
        <label>Pagination (articles/page)
            <input type="number" name="pagination_per_page" value="<?= Helpers::e($settings['pagination_per_page'] ?? ($_ENV['PAGINATION_PER_PAGE'] ?? '6')) ?>">
        </label>
        <button type="submit">Enregistrer</button>
    </form>
</section>
