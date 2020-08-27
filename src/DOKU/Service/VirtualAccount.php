<?php

namespace DOKU\Service;

class VirtualAccount
{
    public function generateMandiriVa($params)
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

        $words = hash('sha256', $formula);

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

        if ($this->config['environment'] == $this->DEV) {
            $url = 'http://dev.dokupay.com/mandiri-virtual-account/v1/payment-code';
        } else {
            $url = 'http: //app-sit.doku.com/mandiri-virtual-account/v1/payment-code';
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
}
