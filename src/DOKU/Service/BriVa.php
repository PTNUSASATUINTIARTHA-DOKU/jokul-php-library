<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorVa;

class BriVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/bri-virtual-account/v2/payment-code';
        return PaycodeGeneratorVa::post($config, $params);
    }
}
