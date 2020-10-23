<?php

namespace DOKU\Service;

use DOKU\Client;
use DOKU\Common\Utils;

class Notification
{
    private $response;
    private $client;
    private $headers;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->headers = getallheaders();
    }

    public function getNotification()
    {
        $config = $this->client->getConfig();
        $signature = Utils::generateSignature($this->headers, $config['shared_key']);
        if ($signature == $this->headers['Signature']) {
            $raw_notification = json_decode(file_get_contents('php://input'), true);
            $this->response = $raw_notification;
        }
        $this->returnResponse($this->response);
        return $this->response;
    }

    function returnResponse($json_data_input)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $json_data_output = array(
            "order" => array(
                "invoice_number" => $json_data_input['order']['invoice_number'],
                "amount" => $json_data_input['order']['amount']
            ),
            "virtual_account_info" => array(
                "virtual_account_number" => $json_data_input['virtual_account_info']['virtual_account_number']
            )
        );

        echo json_encode($json_data_output);
    }
}
