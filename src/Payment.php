<?php

namespace Jetfuel\Lfbpay;

use Jetfuel\Lfbpay\HttpClient\CurlHttpClient;

class Payment
{
    const BASE_API_URL = 'http://gate.lfbpay.com/cooperate/gateway.cgi/';
    const SIGN_TYPE    = 'MD5';
    const API_VERSION  = '1.0.0.0';
    const SUMMARY = 'GOODS_NAME';

    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $baseApiUrl;

    /**
     * @var \Jetfuel\Lfbpay\HttpClient\HttpClientInterface
     */
    protected $httpClient;

    /**
     * Payment constructor.
     *
     * @param string $merchantId
     * @param string $secretKey
     * @param string $baseApiUrl
     */
    protected function __construct($merchantId, $secretKey, $baseApiUrl = null)
    {
        $this->merchantId = $merchantId;
        $this->secretKey = $secretKey;
        $this->baseApiUrl = $baseApiUrl === null ? self::BASE_API_URL : $baseApiUrl;

        //$this->httpClient = new GuzzleHttpClient($this->baseApiUrl);
        $this->httpClient = new CurlHttpClient($this->baseApiUrl);
    }

    /**
     * Sign request payload.
     *
     * @param array $payload
     * @return array
     */
    protected function signPayload(array $payload)
    {
        $payload['sign'] = Signature::generate($payload, $this->secretKey);
        
        return $payload;
    }

    /**
     * Get current time.
     *
     * @return string
     */
    /*protected function getCurrentTime()
    {
        return (new \DateTime('now', new \DateTimeZone(self::TIME_ZONE)))->format(self::TIME_FORMAT);
    }*/
}
