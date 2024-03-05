<?php

namespace App\Providers;

use App\Models\User;
use App\Models\vet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('isAdmin', function(User $user) {
            boo:$can=false;
            $can = ($user->isAdmin)||($user->name=='admin');
            return $can;
        });
        Gate::define('isMaster', function(User $user) {
            boo:$can=false;
            $can = $user->name=='master';
            return $can;
        });
        Gate::define('isVet', function(User $user) {
            boo:$can=false;
            $can = $user->vet()->count();
            return $can;
        });
        
    }
}
