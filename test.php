<?php

require_once "./src/DOKU/Client.php";

$params = array(
    'customerEmail' => 'taufik@doku.com',
    'customerName' => 'Taufik Ismail',
    'amount' => 105.00,
    'invoiceNumber' => 'MINV2020112314168'
);

$hello = new DOKU\Client;
$hello->setEnvironment('development');
$hello->setClientID('123-abc');
$hello->setKey('chUnKr1nkZ');
echo $hello->generateMandiriVa($params);
