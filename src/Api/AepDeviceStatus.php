<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceStatus
{
    private $request;
    private $version = '20181031202028';

    public function __construct(AepSDKRequest $request)
    {
        $this->request = $request;
        $this->request->setVersion($this->version);
    }

    public function getDeviceStatus($data)
    {
        return $this->request->post('/aep_device_status/deviceStatus', $data);
    }

}
