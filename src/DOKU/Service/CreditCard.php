<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorCc;

class CreditCard
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/credit-card/v1/payment-page';
        return PaycodeGeneratorCc::post($config, $params);
    }
}
