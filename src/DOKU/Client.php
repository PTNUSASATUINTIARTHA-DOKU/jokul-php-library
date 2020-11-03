<?php

namespace DOKU;

use DOKU\Service\VirtualAccount;

use DOKU\Service\MandiriVa;

use DOKU\Service\DokuVa;

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

    public function getConfig()
    {
        return $this->config;
    }

    public function generateMandiriVa($params)
    {
        $this->config = $this->getConfig();
        return MandiriVa::generated($this->config, $params);
    }

    public function generateDokuVa($params)
    {
        $this->config = $this->getConfig();
        return DokuVa::generated($this->config, $params);
    }
}
