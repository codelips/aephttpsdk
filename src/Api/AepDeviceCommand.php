<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceCommand extends AepBaseApi
{

    public function createCommand($payload, $deviceId, $productId)
    {
        $data = [
            'content'   => [
                //         payload:指令内容,数据格式为十六进制时需要填十六进制字符串,
                //	      dataType:数据类型：1字符串，2十六进制
                'payload'  => $payload,
                'dataType' => 1,
            ],
            'deviceId'  => $deviceId,
            'operator'  => 'zhugegangtie',
            'productId' => $productId,
            'ttl'       => 7200,
            //    level:指令级别，1或2为设备级别,3为设备组级别，选填。不填默认设备级。
            //    'deviceGroupId'=>100, // 与 deviceId 互斥
            'level'     => 1
        ];
        $this->request->setVersion('20190712225145');
        $this->request->setUseMasterKey(true);
        return $this->request->post('/aep_device_command/command', $data);
    }

}
