<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorEmoney;

class ShopeePay
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/shopeepay-emoney/v2/order';
        return PaycodeGeneratorEmoney::post($config, $params);
    }
}
