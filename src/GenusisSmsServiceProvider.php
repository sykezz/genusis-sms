<?php

namespace Sykez\GenusisSms;

use Illuminate\Support\ServiceProvider;
use Sykez\GenusisSms\Exceptions\InvalidConfiguration;

class GenusisSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(GenusisSmsChannel::class)
            ->needs(GenusisGensuiteClient::class)
            ->give(function () {

                if (is_null(config('services.genusis-sms'))) {
                    throw InvalidConfiguration::configNotSet();
                }

                return new GenusisGensuiteClient(
                    config('services.genusis-sms.client_id'),
                    config('services.genusis-sms.username'),
                    config('services.genusis-sms.private_key'),
                    config('services.genusis-sms.url'),
                    config('services.genusis-sms.debug_log')
                );
            });
    }
}
