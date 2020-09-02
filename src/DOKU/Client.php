<?php

namespace DOKU;

use DOKU\Service\VirtualAccount;

class Client
{

    /**
     * @var array
     */
    private $config = array();

    const SANDBOX = "sandbox";
    const PROD = "production";

    function __construct()
    {
        $this->config['environment'] = Client::SANDBOX;
    }

    public function isProduction()
    {
        $this->config['environment'] = Client::PROD;
    }

    public function setClientID($clientID)
    {
        $this->config['client_id'] = $clientID;
    }

    public function setSharedKey($key)
    {
        $this->config['shared_key'] = $key;
    }

    public function generateMandiriVa($params)
    {
        $va = new VirtualAccount;
        $va->generateMandiriVa($params);
        
    }

    public function generateWords($params)
    {
        $formula =
            $this->config['client_id'] .
            $params['customerEmail'] .
            trim($params['customerName']) .
            $params['amount'] .
            $params['invoiceNumber'] .
            60 .
            "false" .
            $this->config['shared_key'];

        return hash('sha256', $formula);
    }
}
