<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class BcaVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/bca-virtual-account/v2/payment-code';
        return PaycodeGenerator::post($config, $params);
    }
}
