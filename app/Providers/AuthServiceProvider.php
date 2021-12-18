<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        // $this->registerPolicies();

        // Gate::define('admin', function ($user) {
        //     return $user->role == 'admin';
        // });

        // Gate::define('user', function ($user) {
        //     return $user->role == 'user';
        // });
        // Gate::define('semiuser', function ($user) {
        //     $nilai = 0;
        //     if (is_null($user->email_verified_at)) {
        //         $nilai = 1;
        //     }

        //     return $nilai == 1;
        // });
    }
}
