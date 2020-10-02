# Jokul PHP Library
Official PHP Library for Jokul. Visit https://jokul.doku.com for more information about the product and https://jokul.doku.com/docs for the technical documentation.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Setup Configuration](#setup-configuration)
  - [Virtual Account](#virtual-account)
  - [Handling HTTP Notification](#handling-http-notification)
- [Example](#example)
- [Help and Support](#help-and-support)

## Requirements

## Installation

If you are using [Composer](https://getcomposer.org), you can install via composer CLI:

```
composer require doku/jokul-php-library
```

**or**

add this require line to your `composer.json` file:

```json
{
    "require": {
        "doku/jokul-php-library-php": "1.*"
    }
}
```

and run `composer install` on your terminal.

## Usage

### Setup Configuration

Get your Client ID and Shared Key from [Jokul Back Office](https://jokul.doku.com/bo/login).

Setup your configuration:

```php
//instantiate class
$DOKUClient = new DOKU\Client;
// Set your Client ID
$DOKUClient->setClientID('[YOUR_CLIENT_ID]');
// Set your Shared Key
$DOKUClient->setSharedKey('[YOUR_SHARED_KEY]');
// Call this function for production use
$DOKUClient->isProduction();
```
If you want to hit to Sandbox, remove the `$DOKUClient->isProduction();`.

### Virtual Account

To generate Virtual Account, you can call these function:

```
//Call this function to generate mandiri VA

$DOKUClient->generateMandiriVa($params);

$params = array(
    'customerEmail' => 'jokul@doku.com',
    'customerName' => 'Jo Cool',
    'amount' => 100000.00,
    'invoiceNumber' => 'MINV2020112314168'
);
```

### Handling HTTP Notification


```php
//instantiate class
$dokuNotify = new DOKU\Service\Notification();

//get Notify
$response = $dokuNotify->getNotification();
```
