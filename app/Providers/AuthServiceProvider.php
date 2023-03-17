<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // Passport::routes();
        // $startTime = date("Y-m-d H:i:s");
        // $endTime = date("Y-m-d H:i:s",
        // strtotime('+7 day +1 hour +30 minutes +45 seconds',
        // strtotime($startTime)));
        // $expTime = \DateTime::createFromFormat("Y-m-d H:i:s" ,     $endTime );
        // Passport::tokenExpireIn(      $expTime);

        //
    }
}