<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'users' => User::class,
            'admins' => Admin::class,
            'deliveries' => Delivery::class,
            'agents' => Agent::class,
        ]);
    }
}
