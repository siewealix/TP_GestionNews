<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Helpers;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            Helpers::redirect('login');
        }
    }
}
