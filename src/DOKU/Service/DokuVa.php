<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorVa;

class DokuVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = "/doku-virtual-account/v2/payment-code";
        return PaycodeGeneratorVa::post($config, $params);
    }
}
