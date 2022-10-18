<?php

namespace DOKU;

use DOKU\Service\VirtualAccount;

class Client
{
    /**
     * @var array
     */
    private $config = array();

    public function isProduction($value)
    {
        $this->config['environment'] = $value;
    }

    public function setClientID($clientID)
    {
        $this->config['client_id'] = $clientID;
    }

    public function setSharedKey($key)
    {
        $this->config['shared_key'] = $key;
    }

    public function setChannelVA($channel)
    {
        $this->config['channel_uri'] = $channel;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function generateVA($params)
    {
        $this->config = $this->getConfig();
        return VirtualAccount::generated($this->config, $params);
    }
}
