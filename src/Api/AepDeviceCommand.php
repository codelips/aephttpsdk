<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceCommand
{
    private $request;
    private $version='20190712225145';

    public function __construct(AepSDKRequest $request)
    {
        $this->request = $request;
        $this->request->setVersion($this->version);
    }

    public function createCommand($data, $MasterKey)
    {
        return $this->request->post('/aep_device_command/command' . '?MasterKey=' . $MasterKey, $data, ['MasterKey' => $MasterKey]);
    }

}
