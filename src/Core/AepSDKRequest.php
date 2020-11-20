<?php

namespace WingAepSDK\Core;

class AepSDKRequest
{

    private $appKey       = null;
    private $appSecret    = null;
    private $baseHttpUrl  = 'http://ag-api.ctwing.cn';
    private $baseHttpsUrl = 'https://ag-api.ctwing.cn';
    private $version      = '';
    private $masterKey    = null;
    private $useMasterKey = false;
    private $cache        = null;

    /**
     * @param string $version
     * @return AepSDKRequest
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @param bool $useMasterKey
     */
    public function setUseMasterKey(bool $useMasterKey): void
    {
        $this->useMasterKey = $useMasterKey;
    }

    /**
     * AepSdkRequest constructor.
     * @param null $appKey
     * @param null $appSecret
     */
    public function __construct($appKey, $appSecret, $masterKey = null)
    {
        $this->appKey    = $appKey;
        $this->appSecret = $appSecret;
        $this->masterKey = $masterKey;
    }

    private function getMilliTimestamp()
    {
        return (int)(microtime(true) * 1000);
    }

    private function parseUrl($url): array
    {
        $query = parse_url($url);
        $rt    = [];
        if (isset($query['query'])) {
            $args = explode('&', $query['query']);
            foreach ($args as $val) {
                $kv         = explode('=', $val);
                $rt[$kv[0]] = $kv[1];
            }
        }
        $query['path']   = $query['path'] ?? '';
        $query['scheme'] = $query['scheme'] ?? 'http';
        if ($this->useMasterKey && $this->masterKey === null) {
            throw  new \Exception('NEED: MasterKey');
        }
        if ($this->useMasterKey) {
            $rt['MasterKey'] = $this->masterKey;
        }
        $query['args'] = $rt;
        $query['url']  = $query['scheme'] . '://' . $query['host'] . $query['path'];
        if (!empty($query['args'])) {
            $args         = http_build_query($query['args']);
            $query['url'] = $query['url'] . '?' . $args;
        }
        return $query;
    }

    public function post(string $uri, array $postData = [], $header = [])
    {
        $rawUrl = $this->baseHttpsUrl . $uri;
        $query  = $this->parseUrl($rawUrl);
        $body   = json_encode($postData);
        $header = array_merge($header, $this->getHeader($query['args'], $body));
        $this->setCache('post', $query['url'], $header, $body);
        return \Requests::post($query['url'], $header, $body,['blocking'=>false]);
    }

    public function get(string $uri, $header = [])
    {
        $url    = $this->baseHttpsUrl . $uri;
        $query  = $this->parseUrl($url);
        $header = array_merge($header, $this->getHeader($query['args']));
        $this->setCache('get', $query['url'], $header);
        return \Requests::get($query['url'], $header,['blocking'=>false]);
    }

    private function setCache($type, $url, $header, $body = '')
    {
        $this->cache = [
            'type'   => $type,
            'url'    => $url,
            'header' => $header,
            'body'   => $body,
        ];
    }

    /**
     * @return array|null
     */
    public function getCache()
    {
        return $this->cache;
    }

    protected function getHeader(array $queryParams, string $body = '')
    {
        $timestamp = $this->getMilliTimestamp();
        $signature = $this->signature($this->appKey, $this->appSecret, $timestamp, $queryParams, $body);
        $header1   = [];
        if (isset($queryParams['MasterKey'])) {
            $header1['MasterKey'] = $this->masterKey;
        }
        $header1['application'] = $this->appKey;
        $header1['timestamp']   = $timestamp;
        $header1['signature']   = $signature;
        $header1['version']     = $this->version;
        $header1['sdk']         = 0;
//        $header1['Connection']  = 'close';
        return $header1;
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
