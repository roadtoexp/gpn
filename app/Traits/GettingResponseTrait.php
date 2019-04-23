<?php

declare(strict_types = 1);

namespace App\Traits;

use GuzzleHttp\Psr7\Response;
use Vyuldashev\XmlToArray\XmlToArray;

trait GettingResponseTrait
{
    /**
     * @param $response
     *
     * @return array
     */
    public function getResponse($response): array
    {
        $result = [];

        if ($this->isSuccessRequest($response)) {
            $result = $this->collectResponse($response);
        }

        return $result;
    }

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @return bool
     */
    private function isSuccessRequest(Response $response): bool
    {
        return $response->getStatusCode() === 200;
    }

    /**
     * @param $response
     *
     * @return array
     */
    private function collectResponse($response): array
    {
        $response = XmlToArray::convert($response->getBody()->getContents());

        return $response['data'];
    }
}
