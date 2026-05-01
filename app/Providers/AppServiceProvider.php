<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('formateur', function ($user) {
            return $user->role === 'formateur';
        });

        Gate::define('stagiaire', function ($user) {
            return $user->role === 'stagiaire';
        });
    }
}