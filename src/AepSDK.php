<?php

namespace WingAepSDK;

use WingAepSDK\Core\AepSDKRequest;

class AepSDK
{
    private $request = null;

    public function __construct($appKey, $appSecret)
    {
        $this->request = new AepSDKRequest($appKey, $appSecret);
    }

    public function __call($name, $arguments)
    {
        $class = 'WingAepSDK\\Api\\' . $name;
        if (class_exists($class)) {
            return new $class($this->request);
        }
    }

}