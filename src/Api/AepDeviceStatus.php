<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceStatus
{
    private $request;

    public function __construct(AepSDKRequest $request)
    {
        $this->request = $request;
    }

    public function getDeviceStatus($data)
    {
        return $this->request->post('/aep_device_status/deviceStatus', $data);
    }

}
