<?php

namespace WingAepSDK\Core;

class AepSDKRequest
{

    private $appKey       = null;
    private $appSecret    = null;
    private $baseHttpUrl  = 'http://ag-api.ctwing.cn';
    private $baseHttpsUrl = 'https://ag-api.ctwing.cn';

    /**
     * AepSdkRequest constructor.
     * @param null $appKey
     * @param null $appSecret
     */
    public function __construct($appKey, $appSecret)
    {
        $this->appKey    = $appKey;
        $this->appSecret = $appSecret;
    }

    private function getTimestamp()
    {
        return (int)(microtime(true) * 1000);
    }

    private function getParams($query)
    {
        if (empty($query))
            return [];
        $args = explode('&', $query);
        $rt   = [];
        foreach ($args as $val) {
            $kv         = explode('=', $val);
            $rt[$kv[0]] = $kv[1];
        }
        return $rt;
    }

    public function post(string $uri, array $postData = [])
    {
        $url       = $this->baseHttpsUrl . $uri;
        $getParams = $this->getParams(parse_url($url, PHP_URL_QUERY));
        $body      = json_encode($postData);
        $header    = $this->getHeader($getParams, $body);
        return \Requests::post($url, $header, $body);
    }

    public function get(string $uri)
    {
        $url       = $this->baseHttpsUrl . $uri;
        $getParams = $this->getParams(parse_url($url, PHP_URL_QUERY));
        $header    = $this->getHeader($getParams);
        return \Requests::get($url, $header);
    }

    private function getHeader(array $params, string $body = '')
    {
        $timestamp = $this->getTimestamp();
        $signature = $this->signature($timestamp, $params, $body);
        return [
            'application' => $this->appKey,
            'timestamp'   => $timestamp,
            'signature'   => $signature,
            'Date'        => $timestamp,
            'sdk'         => 'GIT: a4fb7fca',
            'version'     => '20181031202028',
            'User-Agent'  => 'Telecom API Gateway Java SDK',
            'Connection'  => 'close',
        ];
    }

    private function signature($timestamp, array $params, string $body = '')
    {
        $code = 'application:' . $this->appKey . "\n" . 'timestamp:' . $timestamp . "\n";
        foreach ($params as $key => $val) {//get params
            $code .= $key . ':' . $val . "\n";
        }
        if (!empty($body)) {//json body
            $code .= $body . "\n";
        }
        return base64_encode(hash_hmac('sha1', $code, $this->appSecret, true));
    }


}
