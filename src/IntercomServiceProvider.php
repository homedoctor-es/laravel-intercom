<?php

/**
 * Part of the Intercom Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Intercom Laravel
 * @version    1.0.0
 * @author     Juan Solá
 * @license    BSD License (3-clause)
 * @copyright (c) 2021, Homedoctor Smart Medicine
 */

namespace HomedoctorEs\Laravel\Intercom;

use HomedoctorEs\Laravel\Intercom\Notifications\Channel\IntercomChannel;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Intercom\IntercomClient;


/**
 * Class IntercomServiceProvider
 *
 * @author Juan Solá <juan.sola@homedoctor.es>
 */
class IntercomServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/intercom.php' => config_path('intercom.php'),
        ]);

        $this->app->when(IntercomChannel::class)
            ->needs(Intercom::class)
            ->give(function ($app) {
                return $this->getIntercomClient($app['config']);
            });
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->singleton('intercom', function ($app) {
            return $this->getIntercomClient($app['config']);
        });

        $this->app->alias('intercom', Intercom::class);

        Notification::extend('intercom', static function (Container $app) {
            return $app->make(IntercomChannel::class);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'intercom',
            Intercom::class
        ];
    }

    /**
     * @param $config
     * @return Intercom
     */
    protected function getIntercomClient($config): Intercom
    {
        $config = $config->get('intercom');
        $client = new IntercomClient(
            $config['api_token'] ?? null,
            null,
            [
                'Intercom-Version' => $config['api_version'] ?? '2.3',
            ]
        );

        return new Intercom($client);
    }

}
