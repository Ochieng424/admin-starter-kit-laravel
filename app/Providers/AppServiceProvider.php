<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        Gate::define('viewApiDocs', function (User $user) {
            return in_array($user->email, ['ochieng.derrick001@gmail.com']);
        });

        LogViewer::auth(function ($request) {
            return $request->user() && in_array($request->user()->email, ['ochieng.derrick001@gmail.com']);
        });
    }
}
