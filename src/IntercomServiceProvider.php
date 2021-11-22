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

use Illuminate\Support\ServiceProvider;


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
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->singleton('intercom', function ($app) {
            $config = $app['config']->get('intercom');
            return new Intercom(
                isset($config['api_token']) ? $config['api_token'] : null,
                null,
                [
                    'Intercom-Version' => isset($config['api_version']) ? $config['api_version'] : '2.3',
                ]
            );
        });

        $this->app->alias('intercom', Intercom::class);
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

}
