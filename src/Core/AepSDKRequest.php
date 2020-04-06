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

    private function getMilliTimestamp()
    {
        return (int)(microtime(true) * 1000);
    }

    private function getQueryParams($url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);
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

    public function post(string $uri, array $postData = [], $header = [])
    {
        $url         = $this->baseHttpsUrl . $uri;
        $queryParams = $this->getQueryParams($url);
        $body        = json_encode($postData);
        $header      = array_merge($header, $this->getHeader($queryParams, $body));
        return \Requests::post($url, $header, $body);
    }

    public function get(string $uri, $header = [])
    {
        $url         = $this->baseHttpsUrl . $uri;
        $queryParams = $this->getQueryParams($url);
        $header      = array_merge($header, $this->getHeader($queryParams));
        return \Requests::get($url, $header);
    }


    protected function getHeader(array $queryParams, string $body = '')
    {
        $timestamp = $this->getMilliTimestamp();
        $signature = $this->signature($this->appKey, $this->appSecret, $timestamp, $queryParams, $body);
        return [
            'application' => $this->appKey,
            'timestamp'   => $timestamp,
            'signature'   => $signature,
            'sdk'         => 0,
            //            'version'     => '20181031202028',
            'version'     => '20190712225145',
            'Connection'  => 'close',
            //            'Date'        => $timestamp,
            //            'User-Agent'  => 'Telecom API Gateway Java SDK',
        ];
    }

    protected function signature($appKey, $secret, $timestamp, array $queryParams, string $body = '')
    {
        $code = 'application:' . $appKey . "\n" . 'timestamp:' . $timestamp . "\n";
        foreach ($queryParams as $key => $val) {//get params
            $code .= $key . ':' . $val . "\n";
        }
        if (!empty($body)) {//json body
            $code .= $body . "\n";
        }
        return base64_encode(hash_hmac('sha1', $code, $secret, true));
    }


}
