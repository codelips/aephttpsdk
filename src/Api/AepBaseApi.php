<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;


abstract class AepBaseApi
{
    /**
     * @var AepSDKRequest
     */
    protected $request;

    public function setRequest(AepSDKRequest $request)
    {
        $this->request = $request;
    }

}