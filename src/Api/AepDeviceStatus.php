<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceStatus
{
    use AepBaseApi;

    public function getDeviceStatus($data)
    {
        $this->getRequest()->setVersion('20181031202028');
        return $this->getRequest()->post('/aep_device_status/deviceStatus', $data);
    }

    public function getDeviceStatusList($data)
    {
        $this->getRequest()->setVersion('20181031202403');
        return $this->getRequest()->post('/aep_device_status/deviceStatusList', $data);
    }

}
