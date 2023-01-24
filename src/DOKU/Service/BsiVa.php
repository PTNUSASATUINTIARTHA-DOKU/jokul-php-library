<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorVa;

class BsiVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/bsm-virtual-account/v2/payment-code';
        return PaycodeGeneratorVa::post($config, $params);
    }
}
