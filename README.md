# jokul-php-library
Official PHP Library for Jokul. Visit https://jokul.doku.com for more information about the product and https://jokul.doku.com/docs for the technical documentation.

## 1. Installation

### 1.a Composer Installation

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

## 2. Usage

### 2.1 General Settings

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
### 2.2 Generate Paycode
```
//Call this function to generate mandiri paycode
$DOKUClient->generateMandiriVa($params);

example for params :
$params = array(
    'customerEmail' => 'jokul@doku.com',
    'customerName' => 'Jo Cool',
    'amount' => 105.00,
    'invoiceNumber' => 'MINV2020112314168'
);
```

### 2.3 Get Notify From DOKU
```php
//instantiate class
$dokuNotify = new DOKU\Service\Notification();
//get Notify
$response = $dokuNotify->getNotification();
```
