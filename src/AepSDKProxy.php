<?php

namespace WingAepSDK;

use someNamespaceA\NamespacedClass;
use WingAepSDK\Api\AepBaseApi;
use WingAepSDK\Core\AepSDKRequest;

/**
 * Class AepSDKProxy
 * @package WingAepSDK
 */
class AepSDKProxy
{
    /**
     * @var AepSDKRequest|null
     */
    private static $request = null;
    /**
     * @var AepSDKProxy|null
     */
    private static $instance = null;
    private        $proxy    = null;

    public function __construct($appKey, $appSecret, $masterKey = null)
    {
        if (self::$request === null) {
            self::$request = new AepSDKRequest($appKey, $appSecret, $masterKey);
        }
    }

    public static function s($appKey = '', $appSecret = '', $masterKey = null)
    {
        if (self::$instance === null) {
            self::$instance = new static($appKey, $appSecret, $masterKey);
        }
        return self::$instance;
    }

    public function for($class)
    {
        $this->proxy = $class;
        $this->proxy->setRequest(self::$request);
        return $this->proxy;
    }

    public function __call($name, $arguments)
    {
        if ($this->proxy === null) {
            throw  new \Exception("Proxy is not Instance");
        }
        return $this->proxy->$name(...$arguments);
    }

}