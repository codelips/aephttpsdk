<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceCommand extends AepBaseApi
{

    public function createCommand($data)
    {
        $this->request->setVersion('20190712225145');
        $this->request->setUseMasterKey(true);
        return $this->request->post('/aep_device_command/command', $data);
    }

}
