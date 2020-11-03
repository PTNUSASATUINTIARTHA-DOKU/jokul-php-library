<?php

namespace DOKU\Service;

class Notification
{
    private $response;

    public function __construct()
    {
    }

    public function getNotification($response)
    {
        return $this->returnResponse($response);
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

        return $json_data_output;
    }
}
