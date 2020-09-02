<?php

namespace DOKU\Service;

class Notification
{
    private $response;

    public function __construct($input_source = "php://input")
    {
        $raw_notification = json_decode(file_get_contents($input_source), true);
        $this->response = $raw_notification;
    }

    public function getNotification()
    {
        return $this->response;
    }
}
