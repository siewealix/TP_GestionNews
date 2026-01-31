<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Connexion';
?>
<section class="auth">
    <h1>Connexion</h1>
    <form method="post" action="<?= Helpers::url('login') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Mot de passe
            <input type="password" name="password" required>
        </label>
        <button type="submit">Se connecter</button>
    </form>
</section>
