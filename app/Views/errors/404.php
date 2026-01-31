<?php
use App\Core\Helpers;
$pageTitle = 'Page introuvable';
?>
<section>
    <h1>404</h1>
    <p>La page demandée est introuvable.</p>
    <a href="<?= Helpers::url('') ?>">Retour à l'accueil</a>
</section>
