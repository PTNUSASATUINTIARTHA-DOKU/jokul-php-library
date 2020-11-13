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

## Payment Channels Supported

Virtual Account

- DOKU VA
- Mandiri VA

## Requirements

- PHP 7.2

## Installation

If you are using [Composer](https://getcomposer.org), you can install via composer CLI:

```
composer require doku/jokul-php-library
```

**or**

add this require line to your `composer.json` file:

example
```json
{
    "require": {
        "doku/jokul-php-library": "2.0.0"
    }
}
```

and run `composer install` on your terminal.

## Usage

### Setup Configuration

Get your Client ID and Shared Key from [Jokul Back Office](https://jokul.doku.com/bo/login).

Setup your configuration:

```php
// Instantiate class
$DOKUClient = new DOKU\Client;
// Set your Client ID
$DOKUClient->setClientID('[YOUR_CLIENT_ID]');
// Set your Shared Key
$DOKUClient->setSharedKey('[YOUR_SHARED_KEY]');
// Call this function for production use
$DOKUClient->isProduction(true);
```
If you want to hit to Sandbox, change to `$DOKUClient->isProduction(false);`.

### Virtual Account

First prepare your payment request data:

```php
// Setup VA payment request data
$params = array(
    'customerEmail' => $arr["email"],
    'customerName' => $arr["customerName"],
    'amount' => $arr["amount"],
    'invoiceNumber' => random_strings(20),
    'expiryTime' => $arr["expiredTime"],
    'info1' => $arr["info1"],
    'info2' => $arr["info2"],
    'info3' => $arr["info3"],
    'reusableStatus' => $arr["reusableStatus"]
);
```

#### Mandiri VA

After preparing the payment request above, call this function to generate Mandiri VA:

```php
// Call this function to generate Mandiri VA
$DOKUClient->generateMandiriVa($params);
```

#### DOKU VA

After preparing the payment request above, call this function to generate DOKU VA:

```php
// Call this function to generate DOKU VA
$DOKUClient->generateDOKUVa($params);
```

### Handling HTTP Notification

For async payment from these channels:

- Virtual Account

We will send the HTTP Notification after the payment made from your customers. Therefore, you will need to handle the notification to update the transaction status on your end. Here is the steps:

1. Setup notification URL on your server that Jokul will send the notification
1. Setup the notification URL to the Payment Configuration on [Jokul Back Office](https://sandbox.doku.com/bo/login)
1. Test the payment with our [Payment Simulator](https://sandbox.doku.com/integration/simulator) (for testing purpose)

Here is the sample of the notification endpoint that you need to setup.

```php
// https://your-domain.com/notify

// Mapping the notification received from Jokul
$headers = getallheaders();
$raw_notification = json_decode(file_get_contents('php://input'), true);

// Handle the Notification
$dokuNotify = new DOKU\Service\Notification();

// Prepare Signature to verify the notification authenticity
$signature = \DOKU\Common\Utils::generateSignature($headers, file_get_contents('php://input'), 'YOUR_SHARED_KEY');

// Verify the notification authenticity
if ($signature == $headers['Signature']) {
    $response = json_encode($dokuNotify->getNotification($raw_notification));
    echo $response;
    // TODO update transaction status on your end to 'SUCCESS'
} else {
    // Return 400 to Jokul if the Signature is not match
    http_response_code(400);
    $response = json_encode($dokuNotify->getNotification($raw_notification));
    echo $response;
    
    // TODO Do Not update transaction status on your end yet
}
```
