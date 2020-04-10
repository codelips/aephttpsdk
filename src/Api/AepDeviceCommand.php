<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceCommand
{
    use AepBaseApi;

    public function createCommand($data)
    {
        $this->getRequest()->setVersion('20190712225145');
        $this->getRequest()->setUseMasterKey(true);
        return $this->getRequest()->post('/aep_device_command/command', $data);
    }

}
