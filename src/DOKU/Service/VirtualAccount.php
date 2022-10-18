<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class VirtualAccount
{

    public static function generated($config, $params)
    {
        // $params['sigver'] = '1.3';
        $params['targetPath'] = '/' . $config['channel_uri'] . '/v2/payment-code';
        return PaycodeGenerator::post($config, $params);
    }
}
