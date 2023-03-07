<?php

namespace DOKU\Common;

use DOKU\Common\Config;

use DOKU\Common\Utils;

class PaycodeGeneratorCc
{
    public static function post($config, $params)
    {
        $header = array();
        $data = array(
            "customer" => array(
                "id" => $params['customerId'],
                "name" => trim($params['customerName']),
                "email" => $params['customerEmail'],
                "phone" => $params['phone'],
                "country" => $params['country'],
                "address" => $params['address']
            ),
            "order" => array(
                "invoice_number" => $params['invoiceNumber'],
                "amount" => $params['amount'],
                "line_items" => $params['lineItems'],
                "failed_url" => $params['urlFail'],
                "callback_url" => $params['urlSuccess'],
                "auto_redirect" => false
            ),
            "override_configuration" => array(
                "themes" => array(
                    "language" => $params['language'] != "" ? $params['language'] : "" ,
                    "background_color" => $params['backgroundColor'] != "" ? $params['backgroundColor'] : "" ,
                    "font_color" => $params['fontColor'] != "" ? $params['fontColor'] : "" ,
                    "button_background_color" => $params['buttonBackgroundColor'] != "" ? $params['buttonBackgroundColor'] : "" ,
                    "button_font_color" => $params['buttonFontColor'] != "" ? $params['buttonFontColor'] : "" ,
                )
            ),
            "additional_info" => array(
                "integration" => array(
                    "name" => "php-library",
                    "version" => "2.1.0"
                )
            )
        );

        if (isset($params['amount'])) {
            $data['order']["amount"] = $params['amount'];
        } else {
            $data['order']["min_amount"] = $params['min_amount'];
            $data['order']["max_amount"] = $params['min_amount'];
        }

        if (isset($params['additional_info'])) {
            foreach ($params['additional_info'] as $key => $value) {
                $data['additional_info'][$key] = $value;
            }
        }

        $requestId = rand(1, 100000);
        $dateTime = gmdate("Y-m-d H:i:s");
        $dateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($dateTime, 0, 19) . "Z";

        $getUrl = Config::getBaseUrl($config['environment']);

        $targetPath = $params['targetPath'];
        $url = $getUrl . $targetPath;

        $header['Client-Id'] = $config['client_id'];
        $header['Request-Id'] = $requestId;
        $header['Request-Timestamp'] = $dateTimeFinal;
        $signature = Utils::generateSignature($header, $targetPath, json_encode($data), $config['shared_key']);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Signature:' . $signature,
            'Request-Id:' . $requestId,
            'Client-Id:' . $config['client_id'],
            'Request-Timestamp:' . $dateTimeFinal,
            'Request-Target:' . $targetPath,

        ));

        $responseJson = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (is_string($responseJson) && $httpcode == 200) {
            return json_decode($responseJson, true);
        } else {
            echo $responseJson;
            return null;
        }
    }
}
