<?php

namespace App\Providers;

use App\Models\Api\Main\Braclet;
use App\Models\Api\Main\Circle;
use App\Models\Api\User\Admin;
use App\Models\Api\User\Gurdian;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Relation::morphMap([
            'admin' => Admin::class,
            'gurdian' => Gurdian::class,
            'user' => User::class ,
            'braclet' => Braclet::class,
            'circle' => Circle::class
        ]);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
