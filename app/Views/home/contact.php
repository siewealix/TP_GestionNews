<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Contact';
?>
<section>
    <h1>Contact</h1>
    <form method="post" action="<?= Helpers::url('contact') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <label>Nom
            <input type="text" name="name" required>
        </label>
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Message
            <textarea name="message" rows="5" required></textarea>
        </label>
        <button type="submit">Envoyer</button>
    </form>
</section>
