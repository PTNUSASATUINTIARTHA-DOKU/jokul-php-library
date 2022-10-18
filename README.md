# Jokul PHP Library

This is fork of [Jokul PHP Library](https://github.com/PTNUSASATUINTIARTHA-DOKU/jokul-php-library)


## Table of Contents

- [Payment Channels Supported](#payment-channels-supported)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Setup Configuration](#setup-configuration)
  - [Virtual Account](#virtual-account)
  - [Handling HTTP Notification](#handling-http-notification)
- [Sample Project](#sample-project)
- [Help and Support](#help-and-support)

## Payment Channels Supported

Virtual Account => `Channel Name`

- BCA = `bca-virtual-account`
- Mandiri = `mandiri-virtual-account`
- Bank Syariah Indonesia (BSI)= `bsm-virtual-account`
- DOKU = `doku-virtual-account`
- BRI = `bri-virtual-account`
- CIMB = `cimb-virtual-account`
- Permata = `permata-virtual-account`
- BNI = `bni-virtual-account`
- Danamon = `danamon-virtual-account`

## Requirements

- PHP 7.2 or above

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
        "doku/jokul-php-library": "2.1.0"
    }
}
```

and run `composer install` on your terminal.

## Usage

### Setup Configuration

Get your Client ID and Shared Key from Jokul Back Office. [Sandbox Jokul Back Office (for testing purpose)](https://sandbox.doku.com/bo/login) / [Production Jokul Back Office (for real payments)](https://jokul.doku.com/bo/login)

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

For further details of each parameter, please refer to our [Jokul Docs](https://jokul.doku.com/docs/docs/jokul-direct/virtual-account/virtual-account-overview).

#### Virtual Account

After preparing the payment request above, call this function to generate BCA VA:

```php
// Set channel Virtual Account
$DOKUClient->setChannelVA("bca-virtual-account");

// Call this function to generate Virtual Account
$DOKUClient->generateVA($params);
```


### Handling HTTP Notification

For async payment from these channels:

- Virtual Account

We will send the HTTP Notification after the payment made from your customers. Therefore, you will need to handle the notification to update the transaction status on your end. Here is the steps:

1. Create notification URL (endpoint) on your server to receieve HTTP POST notification from Jokul. The notification will be sent to you whenever the transaction status is updated on Jokul side. The sample code available in [Jokul Java Example](https://github.com/PTNUSASATUINTIARTHA-DOKU/jokul-java-example).
1. Setup the notification URL that you made to the Payment Configuration on Jokul Back Office. [Sandbox Jokul Back Office (for testing purpose)](https://sandbox.doku.com/bo/login) / [Production Jokul Back Office (for real payments)](https://jokul.doku.com/bo/login)
1. Test the payment with our [Payment Simulator](https://sandbox.doku.com/integration/simulator) (for testing purpose)

Here is the sample of the notification endpoint that you need to setup:

```php
// Mapping the notification received from Jokul
$notifyHeaders = getallheaders();
$notifyBody = json_decode(file_get_contents('php://input'), true); // You can use to parse the value from the notification body
$targetPath = '/payments/notifications'; // Put this value with your payment notification path
$secretKey = 'SK-xxxxxxx'; // Put this value with your Secret Key

// Prepare Signature to verify the notification authenticity
$signature = \DOKU\Common\Utils::generateSignature($notifyHeaders, $targetPath, file_get_contents('php://input'), $secretKey);

// Verify the notification authenticity
if ($signature == $notifyHeaders['Signature']) {
    http_response_code(200); // Return 200 Success to Jokul if the Signature is match
    // TODO update transaction status on your end to 'SUCCESS'
} else {
    http_response_code(401); // Return 401 Unauthorized to Jokul if the Signature is not match
    // TODO Do Not update transaction status on your end yet
}
```

For further reference, please refer to our [Jokul Docs](https://jokul.doku.com/docs).


## Help and Support

Got any issues? Found a bug? Have a feature requests? You can [open new issue](https://github.com/PTNUSASATUINTIARTHA-DOKU/jokul-php-library/issues/new).

For further information, you can contact us on [care@doku.com](mailto:care@doku.com).
