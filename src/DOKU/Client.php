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

    public function getConfig(){
        return $this->config;
    }

    public function generateMandiriVa($params)
    {
        $this->config = $this->getConfig();
        $words = $this->generateWords($params);

        $data = array(
            "client" => array(
                "id" => $this->config['client_id']
            ),
            "order" => array(
                "invoice_number" => $params['invoiceNumber'],
                "amount" => $params['amount']
            ),
            "virtual_account_info" => array(
                "expired_time" => 60,
                "reusable_status" => 'false',
            ),
            "customer" => array(
                "name" => trim($params['customerName']),
                "email" => $params['customerEmail']
            ),
            "security" => array(
                "check_sum" => $words
            )
        );

        if ($this->config['environment'] == Client::SANDBOX) {
            $url = 'http: //api-sit.doku.com/mandiri-virtual-account/v1/payment-code';
        } else {
            $url = 'http: //api-sit.doku.com/mandiri-virtual-account/v1/payment-code';
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseJson = curl_exec($ch);

        curl_close($ch);

        if (is_string($responseJson)) {
            // echo json_decode($responseJson, true);
            print_r($responseJson);
        } else {
            print_r($responseJson);
        }
        
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
