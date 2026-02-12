<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Note;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.preline');
        Paginator::defaultSimpleView('vendor.pagination.preline');

        Gate::define('admin-only', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('create-note', function (User $user) {
            return !$user->isAdmin(); // Only editors can create notes
        });

        // Global check for UI visibility (SPA compatibility)
        Gate::define('edit-note', function (User $user) {
            return $user->isAdmin(); // Only admins can edit notes
        });

        // Global check for UI visibility (SPA compatibility)
        Gate::define('delete-note', function (User $user) {
            return $user->isAdmin(); // Only admins can delete notes
        });
    }
}
