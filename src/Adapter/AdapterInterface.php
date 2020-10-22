<?php

namespace BootIq\ServiceLayer\Adapter;

use BootIq\ServiceLayer\Request\RequestInterface;
use BootIq\ServiceLayer\Response\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

interface AdapterInterface
{
    const DEFAULT_KEY_PREFIX = 'bootiq_service_layer_';
    const DEFAULT_TIMEOUT = 10;

    /**
     * @param CacheInterface $cache
     * @return void
     */
    public function setCache(CacheInterface $cache);

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * @param float $timeout
     * @return void
     */
    public function setTimeout(float $timeout);

    /**
     * @param RequestInterface $request
     * @param array $requestOptions
     * @return ResponseInterface
     */
    public function call(RequestInterface $request, array $requestOptions = []): ResponseInterface;
}
