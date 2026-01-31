<?php
use App\Core\Helpers;
$pageTitle = 'Erreur serveur';
?>
<section>
    <h1>Erreur interne</h1>
    <p>Une erreur est survenue. Merci de réessayer plus tard.</p>
    <a href="<?= Helpers::url('') ?>">Retour à l'accueil</a>
</section>
