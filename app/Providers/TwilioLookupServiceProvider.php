<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Service\Twilio\PhoneNumberLookupService;

class TwilioLookupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(PhoneNumberLookupService::class, function($app) {
        //     return new PhoneNumberLookupService(
        //         $info->t_auth_sid,       // TWILIO_AUTH_SID
        //         $info->t_auth_token        // TWILIO_AUTH_TOKEN
        //     );
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
