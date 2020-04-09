<?php

namespace WingAepSDK\Api;

use WingAepSDK\Core\AepSDKRequest;

class AepDeviceStatus extends AepBaseApi
{


    public function getDeviceStatus($deviceId, $productId)
    {
        $data = [
            "productId" => $productId,
            'deviceId'  => $deviceId,
            'datasetId' => 'APPdata'
        ];
        $this->request->setVersion('20181031202028');
        return $this->request->post('/aep_device_status/deviceStatus', $data);
    }

    public function getDeviceStatusList($deviceId, $productId)
    {
        $data = ['productId'=>$productId,'deviceId'=>$deviceId];
//        $data=[];
//        foreach ($queryData as $val) {
////            $data['deviceId'][] = $val['deviceId'];
//            $data[] = [
//                'deviceId'  => $val['deviceId'],
//                'productId' => $val['productId'],
//                'datasetId' => 'APPdata',
//            ];
//        }
//        var_export($data);die;
        $this->request->setVersion('20181031202403');
        return $this->request->post('/aep_device_status/deviceStatusList', $data);
    }

}
