Intercom SDK integration for Laravel
===================================
Laravel integration for the Intercom SDK.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require homedoctor-es/laravel-intercom
```

or add

```json
...
    "require": {
        "homedoctor-es/laravel-intercom": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \HomedoctorEs\Laravel\Intercom\IntercomServiceProvider::class,
    ];
];
```

2. If you want, you can add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'Intercom' => \HomedoctorEs\Laravel\Intercom\Facades\Intercom::class,
    ];
];
```

3. Publish the Intercom provider
```
php artisan vendor:publish --provider="HomedoctorEs\Laravel\Intercom\IntercomServiceProvider"
```

4. Set the reference, api_key and base_url in the config/intercom.php file.

config/intercom.php

```php
return [
    'api_token' => env('HOLDED_API_TOKEN'),
    'api_version' => env('HOLDED_API_VERSION', '2.3')
];
```

5. Or use .env file
```
HOLDED_API_TOKEN=
HOLDED_API_VERSION=2.3
```

## Usage

You can use the facade alias Intercom to execute services of the Intercom sdk. The
authentication params will be automatically injected.

```php
$contacts = \HomedoctorEs\Laravel\Intercom\Facades\Intercom::contact();
```

Or use Laravel Service Container to get The Intercom Instance.

```php
app(\HomedoctorEs\Laravel\Intercom\Intercom::class)->contact();
```

Once you have done this steps, you can use all Intercom SDK endpoints as are described in the sdk package documentation.