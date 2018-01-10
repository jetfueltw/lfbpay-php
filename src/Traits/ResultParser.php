<?php

namespace Jetfuel\Lfbpay\Traits;

trait ResultParser
{
    /**
     * Parse XML format response to array.
     *
     * @param string $response
     * @return array
     */
    public function parseResponse($response)
    {
        var_dump($response);
        $dinpay = new \SimpleXMLElement($response);

        return json_decode(json_encode($dinpay->response[0]), true);
    }
}
