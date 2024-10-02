<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('manage-roles', function(User $user)
        {
            return $user->id_role==1;

        });

        Gate::define('manage-users', function(User $user)
        {
            $userPermission =  $user->userPermissions;
            return $userPermission->first()->permission->where('title', 'manage-users')->count() == 1;
        });

        Gate:: define('manage-system', function(User $user)
        {
            $userPermission =  $user->userPermissions;
            return $userPermission->first()->permission->where('title', 'manage-system')->count() == 1;
        });


        //
    }
}
