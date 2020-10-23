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
        return $this->response;
    }
}
