<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class BsiVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/bsm-virtual-account/v2/payment-code';
        return PaycodeGenerator::post($config, $params);
    }
}
