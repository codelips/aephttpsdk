# 电信AEP HTTP SDK

### usage
获取设备状态信息
```php
<?php

include './vendor/autoload.php';

$res = \WingAepSDK\AepSDKProxy::s('填写你的appKey','填写你的appSecret','db0f63f27222f027')
->for(new \WingAepSDK\Api\AepDeviceStatus())
->getDeviceStatus(
   [
    'productId'=>'111111111',
    'deviceId'=>'d874e692bde7452b8789cf39cfe94e75',
    'datasetId'=>'APPdata',
   ]
);
```
