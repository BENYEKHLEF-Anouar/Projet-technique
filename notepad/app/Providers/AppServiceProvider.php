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
            \Illuminate\Support\Facades\Log::info("Gate Check: $ability for User {$user->id} (Admin: " . ($user->hasRole('admin') ? 'Yes' : 'No') . ")");
            return $user->hasRole('admin') ? true : null;
        });

        Gate::define('view-notes', function (User $user) {
            return $user->hasPermissionTo('view-notes');
        });

        Gate::define('create-note', function (User $user) {
            return $user->hasPermissionTo('create-note');
        });

        Gate::define('update-note', function (User $user, Note $note) {
            $permission = $user->hasPermissionTo('edit-any-note') ||
                ($user->hasPermissionTo('edit-own-note') && $note->user_id === $user->id);
            \Illuminate\Support\Facades\Log::info("Update Gate: User {$user->id}, Note Owner {$note->user_id}. Permission: " . ($permission ? 'Granted' : 'Denied'));
            return $permission;
        });

        Gate::define('delete-note', function (User $user, Note $note) {
            $permission = $user->hasPermissionTo('delete-any-note') ||
                ($user->hasPermissionTo('delete-own-note') && $note->user_id === $user->id);
            \Illuminate\Support\Facades\Log::info("Delete Gate: User {$user->id}, Note Owner {$note->user_id}. Permission: " . ($permission ? 'Granted' : 'Denied'));
            return $permission;
        });
    }
}
