<?php

namespace DOKU\Service;

use DOKU\Common\PaycodeGeneratorEmoney;

class DokuWallet
{

    public static function generated($config, $params)
    {
        $params['targetPath'] = '/dokuwallet-emoney/v1/payment';
        return PaycodeGeneratorEmoney::post($config, $params);
    }
}
