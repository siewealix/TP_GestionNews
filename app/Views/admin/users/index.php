<?php
use App\Core\Csrf;
use App\Core\Helpers;
$pageTitle = 'Utilisateurs';
?>
<section>
    <h1>Utilisateurs</h1>
    <form method="post" action="<?= Helpers::url('admin/users') ?>">
        <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
        <input type="text" name="name" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="editor">Éditeur</option>
        </select>
        <button type="submit">Ajouter</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= Helpers::e($user['name']) ?></td>
                    <td><?= Helpers::e($user['email']) ?></td>
                    <td><?= Helpers::e($user['role']) ?></td>
                    <td>
                        <form method="post" action="<?= Helpers::url('admin/users/' . $user['id'] . '/delete') ?>">
                            <input type="hidden" name="csrf_token" value="<?= Csrf::token() ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
