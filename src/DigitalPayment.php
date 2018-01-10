<?php

namespace Jetfuel\Lfbpay;

use Jetfuel\Lfbpay\Traits\ResultParser;

class DigitalPayment extends Payment
{
    use ResultParser;
 
    /**
     * DigitalPayment constructor.
     *
     * @param string $merchantId
     * @param string $privateKey
     * @param null|string $baseApiUrl
     */
    public function __construct($merchantId, $privateKey, $baseApiUrl = null)
    {
        $baseApiUrl = $baseApiUrl === null ? self::BASE_API_URL : $baseApiUrl;

        parent::__construct($merchantId, $privateKey, $baseApiUrl);
    }

    /**
     * Create digital payment order.
     *
     * @param string $tradeNo
     * @param string $channel
     * @param float $amount
     * @param string $clientIp
     * @param string $notifyUrl
     * @return array
     */
    public function order($tradeNo, $channel, $amount, $clientIp, $notifyUrl)
    {
        $payload = $this->signPayload([
            'service'   =>  'TRADE.SCANPAY',
            'version'   =>  parent::API_VERSION,
            'merId'     =>  $this->merchantId,
            'typeId'    =>  $channel,
            'tradeNo'   =>  $tradeNo,
            'amount'    =>  $amount,
            'notifyUrl' =>  $notifyUrl,
            'summary'   =>  parent::SUMMARY,
            'clientIp'  =>  $clientIp,
        ]);
        
        $data = Signature::buildBaseString($payload);
        var_dump($data);

        return $this->parseResponse($this->httpClient->post('', $data));
    }
}
