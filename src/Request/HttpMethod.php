<?php

namespace BootIq\ServiceLayer\Request;

use GuzzleHttp\RequestOptions;

abstract class HttpMethod implements RequestInterface
{

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getHeader(string $key)
    {
        if (!isset($this->headers[$key])) {
            return null;
        }
        return $this->headers[$key];
    }

    /**
     * @return string
     */
    public function getDataRequestOption(): string
    {
        return RequestOptions::JSON;
    }
}
