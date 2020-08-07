<?php

namespace DOKU;

class Client
{

    public function getMandiriPaycode($params)
    {
        $formula =
            $params->clientId .
            $params->customerEmail .
            trim($params->customerName) .
            $params->amount .
            $params->invoiceNumber .
            60 .
            "false" .
            $params->sharedKey;

        $words = hash('sha256', $formula);

        $data = array(
            "client" => array(
                "id" => $params->clientId
            ),
            "order" => array(
                "invoice_number" => $params->invoiceNumber,
                "amount" => $params->amount
            ),
            "virtual_account_info" => array(
                "expired_time" => 60,
                "reusable_status" => 'false',
            ),
            "customer" => array(
                "name" => trim($params->customerName),
                "email" => $params->customerEmail
            ),
            "security" => array(
                "check_sum" => $words
            )
        );

        if ($params->environment == 'development') {
            $url = 'http://app-sit.doku.com/mandiri-virtual-account/v1/payment-code';
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
            return json_decode($responseJson, true);
        } else {
            return $responseJson;
        }
    }
}
