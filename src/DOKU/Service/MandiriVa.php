<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGenerator;

class MandiriVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/mandiri-virtual-account/v2/payment-code';
        $params['sigver'] = '1.3';
        return PaycodeGenerator::post($config, $params);
    }
}
