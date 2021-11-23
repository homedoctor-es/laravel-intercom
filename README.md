Intercom SDK integration for Laravel
===================================
Laravel integration for the [Intercom SDK](https://github.com/intercom/intercom-php).

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
    'api_version' => env('HOLDED_API_VERSION', '2.3'),
    'admin_user_id' => env('INTERCOM_ADMIN_USER_ID')
];
```

5. Or use .env file
```
HOLDED_API_TOKEN=
HOLDED_API_VERSION=2.3
INTERCOM_ADMIN_USER_ID=
```

## Usage

You can use the facade alias Intercom to execute services of the Intercom sdk. The
authentication params will be automatically injected.

```php
$contacts = \HomedoctorEs\Laravel\Intercom\Facades\Intercom::users();
```

Or use Laravel Service Container to get The Intercom Instance.

```php
app(\HomedoctorEs\Laravel\Intercom\Intercom::class)->users();
```

Once you have done this steps, you can use all Intercom SDK endpoints as are described in the [sdk package documentation](https://github.com/intercom/intercom-php).

##Notification channel usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use HomedoctorEs\Laravel\Intercom\Notifications\Channel\IntercomChannel;
use HomedoctorEs\Laravel\Intercom\Notifications\Messages\IntercomMessage;
use Illuminate\Notifications\Notification;

class IntercomNotification extends Notification
{
    public function via($notifiable)
    {
        return ["intercom"];
    }

    public function toIntercom($notifiable): IntercomMessage
    {
        return IntercomMessage::create("This is a test message")
            ->from(config('intercom.admin_user_id'))
            ->toUserId(xxxxx);  //this param can be resolved later in routeNotificationForIntercom
    }
}
```

And/or in your notifiable model define method returning an array or null if not routed field. Your model must be use Notifiable trait- 

```php
class User
{
    use Notifiable;

    // ...

    public function routeNotificationForIntercom($notification): ?array
    {
        if (!$this->intercom_contact_id) {
            return null;
        }
        return [
            'type' => 'user',
            'id' => $this->intercom_contact_id
        ];
    }
}
```

### Available methods

- `body('')`: Accepts a string value for the Intercom message body
- `email()`: Accepts a string value for the Intercom message type `email`
- `inapp()`: Accepts a string value for the Intercom message type `inapp` (default)
- `subject('')`: Accepts a string value for the Intercom message body (using with `email` type)
- `plain()`:  Accepts a string value for the Intercom message plain template
- `personal()`: Accepts a string value for the Intercom message personal template
- `from('123')`: Accepts a string value of the admin's id (sender)
- `to(['type' => 'user', 'id' => '321'])`: Accepts an array value for the recipient data
- `toUserId('')`: Accepts a string value for the Intercom message user by id recipient
- `toUserEmail('')`: Accepts a string value for the Intercom message user by email recipient
- `toContactId('')`: Accepts a string value for the Intercom message contact by id recipient

More info about fields read in [Intercom API Reference](https://developers.intercom.com/intercom-api-reference/reference#admin-initiated-conversation)