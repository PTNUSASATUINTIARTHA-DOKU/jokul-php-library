<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorVa;

class MandiriVa
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/mandiri-virtual-account/v2/payment-code';
        return PaycodeGeneratorVa::post($config, $params);
    }
}
