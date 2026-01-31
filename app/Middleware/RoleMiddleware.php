<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Helpers;

class RoleMiddleware
{
    public static function handle(string $role): void
    {
        if (!Auth::check() || !Auth::hasRole($role)) {
            Helpers::redirect('admin');
        }
    }
}
