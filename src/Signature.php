<?php

namespace Jetfuel\Lfbpay;

class Signature
{
    /**
     * Generate signature.
     *
     * @param array $payload
     * @param string $privateKey
     * @return string
     */
    public static function generate(array $payload, $secretKey)
    {
        $baseString = self::buildBaseString($payload) . $secretKey;

        return self::md5Hash($baseString);
    }

    /**
     * Validate signature.
     *
     * @param array $payload
     * @param string $publicKey
     * @param string $signature
     * @return bool
     */
    public static function validate(array $payload, $publicKey, $signature)
    {
        $baseString = self::buildBaseString($payload);

        return self::rsaVerify($baseString, $publicKey, $signature);
    }

    public static function buildBaseString(array $payload)
    {
        //ksort($payload);

        $baseString = '';
        foreach ($payload as $key => $value) {
            $baseString .= $key.'='.$value.'&';
        }

        return rtrim($baseString, '&');
    }

    private static function md5Hash($data)
    {
        //return strtoupper(md5($data));
        return md5($data);
    }

    private static function rsaSign($baseString, $privateKey)
    {
        $privateKey = openssl_get_privatekey($privateKey);

        openssl_sign($baseString, $signature, $privateKey, OPENSSL_ALGO_MD5);

        return $signature;
    }

    private static function rsaVerify($baseString, $publicKey, $signature)
    {
        $signature = base64_decode($signature);

        $publicKey = openssl_get_publickey($publicKey);

        return openssl_verify($baseString, $signature, $publicKey, OPENSSL_ALGO_MD5) > 0;
    }
}
