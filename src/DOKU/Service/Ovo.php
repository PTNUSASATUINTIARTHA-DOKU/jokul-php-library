<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorEmoney;

class Ovo
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/ovo-emoney/v1/payment';
        return PaycodeGeneratorEmoney::post($config, $params);
    }
}
