# Genusis SMS Gateway (Gensuite API) Notification Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sykez/genusis-sms.svg?style=flat-square)](https://packagist.org/packages/sykez/genusis-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/sykez/genusis-sms.svg?style=flat-square)](https://packagist.org/packages/sykez/genusis-sms)

This package makes it easy to send notifications using [Genusis SMS Gateway](https://genusis.com/) via Gensuite API with Laravel.

## Contents

- [Contents](#contents)
- [Installation](#installation)
  - [Setting up the Genusis SMS service](#setting-up-the-genusis-sms-service)
- [Usage](#usage)
  - [Sending Notification](#sending-notification)
  - [Routing Notification](#routing-notification)
- [Logs & Debug](#logs--debug)
- [License](#license)

## Installation

Install package via Composer:

```
composer require sykez/genusis-sms
```

### Setting up the Genusis SMS service

Add the service configration into your `config/services.php`:

```php
'genusis-sms' => [
	'client_id' => env('GENUSIS_SMS_CLIENT_ID', null),
	'username' => env('GENUSIS_SMS_USERNAME', null),
	'private_key' => env('GENUSIS_SMS_PRIVATE_KEY', null),
	'url' => env('GENUSIS_SMS_URL', null),
	'debug_log' => env('GENUSIS_SMS_DEBUG_LOG', false),
],
```

Add the environment variablesinto your `.env` and set your Client ID, Username, Private Key and API URL.

```
GENUSIS_SMS_CLIENT_ID=
GENUSIS_SMS_USERNAME=
GENUSIS_SMS_PRIVATE_KEY=
GENUSIS_SMS_URL=
```

## Usage

Now you can send SMS from your notification:

### Sending Notification

```php
use Sykez\GenusisSms\GenusisSmsChannel;
use Sykez\GenusisSms\GenusisSmsMessage;
use Illuminate\Notifications\Notification;

class SendSms extends Notification
{
    public function via($notifiable)
    {
        return [GenusisSmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return (new GenusisSmsMessage)->content("Hello there!");
    }
}
```

### Routing Notification

You can route the notification to a phone number with `to()`:

```php
public function toSms($notifiable)
{
	return (new GenusisSmsMessage)->content("Hello there!")->to(01234567891);
}
```

Or you can add `routeNotificationForSms()` method in your notifiable model:

```php
public function routeNotificationForSms()
{
    return $this->phone_number;
}
```

You can also do on-demand notifications:

```php
use Illuminate\Support\Facades\Notification;
Notification::route('sms', '01234567891')->notify(new App\Notifications\SendSms(['Hello again.']));
```

## Logs & Debug

You can set your `GENUSIS_SMS_DEBUG_LOG=true` in your `.env` to send all requests and responses to into your [Laravel logs](https://laravel.com/docs/master/logging).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
