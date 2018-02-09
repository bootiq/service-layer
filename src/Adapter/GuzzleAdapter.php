<?php

namespace BootIq\ServiceLayer\Adapter;

use BootIq\ServiceLayer\Enum\HttpCode;
use BootIq\ServiceLayer\Request\RequestInterface;
use BootIq\ServiceLayer\Response\ResponseFactoryInterface;
use BootIq\ServiceLayer\Response\ResponseInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;

class GuzzleAdapter implements AdapterInterface
{

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $urn;

    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var CacheInterface|null
     */
    protected $cache;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var float
     */
    protected $timeout = self::DEFAULT_TIMEOUT;

    /**
     * GuzzleAdapter constructor.
     * @param ClientInterface $client
     * @param ResponseFactoryInterface $responseFactory
     * @param string $urn
     */
    public function __construct(
        ClientInterface $client,
        ResponseFactoryInterface $responseFactory,
        string $urn
    ) {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
        $this->urn = preg_replace('/\\/$/', '', $urn);
        $this->logger = new NullLogger();
    }

    /**
     * @param CacheInterface $cache
     * @return void
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param float $timeout
     * @return void
     */
    public function setTimeout(float $timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientException
     * @throws \Exception
     */
    public function call(RequestInterface $request): ResponseInterface
    {
        if ($this->cache !== null && $request->isCacheable()) {
            return $this->loadFromCache($request);
        }
        return $this->loadFromApi($request);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientException
     * @throws \Exception
     */
    protected function loadFromApi(RequestInterface $request): ResponseInterface
    {
        $uri = $this->urn . '/' . $request->getEndpoint();
        $data = $request->getData();

        $options = [
            RequestOptions::TIMEOUT => $this->timeout,
        ];

        if ($data !== null) {
            $dataRequestOption = $request->getDataRequestOption();
            if (!in_array($dataRequestOption, [RequestOptions::JSON, RequestOptions::FORM_PARAMS])) {
                throw new \InvalidArgumentException('Unknow data request option (' . $dataRequestOption . ')');
            }
            $options[$dataRequestOption] = $data;
        }

        $requestHeaders = $request->getHeaders();
        if (!empty($requestHeaders)) {
            $options[RequestOptions::HEADERS] = $requestHeaders;
        }

        $start = microtime(true);
        try {
            $response = $this->client->request($request->getMethod(), $uri, $options);
            $end = microtime(true);
        } catch (BadResponseException $exception) {
            $end = microtime(true);
            $response = $exception->getResponse();
            if ($response === null) {
                $this->logger->error($exception, [$request, ($end - $start)]);
                throw $exception;
            }
        } catch (\Exception $exception) {
            $end = microtime(true);
            $this->logger->critical($exception, [$request, ($end - $start)]);
            throw $exception;
        }

        $statusCode = $response->getStatusCode();
        if (!in_array($statusCode, HttpCode::SUCCESS_CODES)) {
            $this->logger->warning(((string)$response->getStatusCode()), [$request, ($end - $start)]);
            return $this->responseFactory->createError($response);
        }
        $this->logger->info(((string)$response->getStatusCode()), [$request, ($end - $start)]);
        return $this->responseFactory->createSuccess($response);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    protected function loadFromCache(RequestInterface $request): ResponseInterface
    {
        $cacheKey = $this->getCacheKey($request);

        if (null === $this->cache) {
            return $this->loadFromApi($request);
        }

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $response = $this->loadFromApi($request);
        if ($response->isError()) {
            return $response;
        }

        $this->cache->set($cacheKey, $response);
        return $response;
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    protected function getCacheKey(RequestInterface $request): string
    {
        $data = $request->getData();
        $stringForHash = $request->getEndpoint();
        if ($data !== null) {
            $jsonData = \GuzzleHttp\json_encode($request->getData());
            $stringForHash .= $jsonData;
        }
        return self::DEFAULT_KEY_PREFIX . md5($stringForHash);
    }
}
