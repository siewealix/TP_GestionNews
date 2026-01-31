<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Helpers;
use App\Middleware\AuthMiddleware;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $settings = Setting::all();
        $this->adminView('settings/index', compact('settings'));
    }

    public function update(): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/settings');
        }

        Setting::update([
            'site_name' => $_POST['site_name'] ?? 'Gestion News',
            'contact_email' => $_POST['contact_email'] ?? '',
            'pagination_per_page' => $_POST['pagination_per_page'] ?? '6',
        ]);

        Flash::set('success', 'Paramètres mis à jour.');
        Helpers::redirect('admin/settings');
    }
}
