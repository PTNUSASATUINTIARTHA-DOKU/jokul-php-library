<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class DokuVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = "/doku-virtual-account/v2/payment-code";
        return PaycodeGenerator::post($config, $params);
    }
}
