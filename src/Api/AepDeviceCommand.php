<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceCommand
{
    private $request;

    public function __construct(AepSDKRequest $request)
    {
        $this->request = $request;
    }

    public function createCommand($data, $MasterKey)
    {
        return $this->request->post('/aep_device_command/command' . '?MasterKey=' . $MasterKey, $data, ['MasterKey' => $MasterKey]);
    }

}
