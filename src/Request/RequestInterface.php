<?php

namespace BootIq\ServiceLayer\Request;

interface RequestInterface
{

    /**
     * @return bool
     */
    public function isCacheable(): bool;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * @return array|null
     */
    public function getData();

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value);

    /**
     * @return string
     */
    public function getDataRequestOption(): string;
}
