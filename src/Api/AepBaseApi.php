<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;


trait AepBaseApi
{
    /**
     * @var AepSDKRequest
     */
    protected $request;

    /**
     * @return AepSDKRequest
     */
    public function getRequest(): AepSDKRequest
    {
        return $this->request;
    }

    public function setRequest(AepSDKRequest $request)
    {
        $this->request = $request;
    }

}