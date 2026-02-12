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

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Gate::define('view-notes', function (User $user) {
            return $user->hasPermissionTo('view-notes');
        });

        Gate::define('create-note', function (User $user) {
            return !$user->isAdmin(); // Only non-admins (editors) can create notes
        });

        Gate::define('manage-note', function (User $user, Note $note) {
            return $user->isAdmin() || $user->id === $note->user_id;
        });
    }
}
