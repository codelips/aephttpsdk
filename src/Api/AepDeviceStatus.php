<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceStatus extends AepBaseApi
{

    public function getDeviceStatus($data)
    {
        $this->request->setVersion('20181031202028');
        $this->request->setUseMasterKey(false);
        return $this->request->post('/aep_device_status/deviceStatus', $data);
    }

    public function getDeviceStatusList($data)
    {
        $this->request->setVersion('20181031202403');
        $this->request->setUseMasterKey(false);
        return $this->request->post('/aep_device_status/deviceStatusList', $data);
    }

}
