# 电信AEP HTTP SDK

### usage
获取设备状态信息
```php
<?php

include './vendor/autoload.php';
include './src/Core/AepSDKRequest.php';

$aepsdk = new \WingAepSDK\AepSDK('填写你的appKey','填写你的appSecret');
$res = $aepsdk->AepDeviceStatus()->getDeviceStatus(
   [
    'productId'=>'111111111',
    'deviceId'=>'d874e692bde7452b8789cf39cfe94e75',
    'datasetId'=>'APPdata',
   ]
);
```
