<?php

namespace BootIqTest\ServiceLayer\Adapter;

use BootIq\ServiceLayer\Adapter\AdapterInterface;
use BootIq\ServiceLayer\Adapter\GuzzleAdapter;
use BootIq\ServiceLayer\Enum\HttpCode;
use BootIq\ServiceLayer\Enum\HttpMethod;
use BootIq\ServiceLayer\Request\RequestInterface;
use BootIq\ServiceLayer\Response\ResponseFactoryInterface;
use BootIq\ServiceLayer\Response\ResponseInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Log\LoggerInterface;

class GuzzleAdapterTest extends TestCase
{

    /**
     * @var ClientInterface|MockObject
     */
    private $client;

    /**
     * @var string
     */
    private $urn;

    /**
     * @var ResponseFactoryInterface|MockObject
     */
    private $responseFactory;

    /**
     * @var LoggerInterface|MockObject
     */
    private $logger;

    /**
     * @var GuzzleAdapter
     */
    private $adapter;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createMock(ClientInterface::class);
        $this->urn = uniqid();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->responseFactory = $this->createMock(ResponseFactoryInterface::class);

        $this->adapter = new GuzzleAdapter(
            $this->client,
            $this->responseFactory,
            $this->urn
        );
        $this->adapter->setLogger($this->logger);
    }

    public function testSuccess()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;

        $request = $this->createMock(RequestInterface::class);
        $clientResponse = $this->createMock(PsrResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn(null);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willReturn($clientResponse);
        $clientResponse->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(HttpCode::HTTP_CODE_OK);
        $this->logger->expects(self::once())
            ->method('info');
        $this->responseFactory->expects(self::once())
            ->method('createSuccess')
            ->with($clientResponse)
            ->willReturn($response);

        $result = $this->adapter->call($request);
        $this->assertEquals($response, $result);
    }

    public function testDataNotEmptySuccess()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;
        $data = uniqid();

        $request = $this->createMock(RequestInterface::class);
        $clientResponse = $this->createMock(PsrResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn($data);
        $request->expects(self::once())
            ->method('getDataRequestOption')
            ->willReturn(RequestOptions::JSON);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $options[RequestOptions::JSON] = $data;
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willReturn($clientResponse);
        $clientResponse->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(HttpCode::HTTP_CODE_OK);
        $this->logger->expects(self::once())
            ->method('info');
        $this->responseFactory->expects(self::once())
            ->method('createSuccess')
            ->with($clientResponse)
            ->willReturn($response);

        $result = $this->adapter->call($request);
        $this->assertEquals($response, $result);
    }

    public function testDataNotEmptySuccessQuery()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;
        $data = uniqid();

        $request = $this->createMock(RequestInterface::class);
        $clientResponse = $this->createMock(PsrResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn($data);
        $request->expects(self::once())
            ->method('getDataRequestOption')
            ->willReturn(RequestOptions::QUERY);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $options[RequestOptions::QUERY] = $data;
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willReturn($clientResponse);
        $clientResponse->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(HttpCode::HTTP_CODE_OK);
        $this->logger->expects(self::once())
            ->method('info');
        $this->responseFactory->expects(self::once())
            ->method('createSuccess')
            ->with($clientResponse)
            ->willReturn($response);

        $result = $this->adapter->call($request);
        $this->assertEquals($response, $result);
    }

    public function testNotSuccess()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;

        $request = $this->createMock(RequestInterface::class);
        $clientResponse = $this->createMock(PsrResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn(null);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willReturn($clientResponse);
        $clientResponse->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(HttpCode::HTTP_CODE_NOT_FOUND);
        $this->logger->expects(self::once())
            ->method('warning');
        $this->responseFactory->expects(self::once())
            ->method('createError')
            ->with($clientResponse)
            ->willReturn($response);

        $result = $this->adapter->call($request);
        $this->assertEquals($response, $result);
    }

    public function testException()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;

        $request = $this->createMock(RequestInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn(null);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willThrowException(new \Exception());
        $this->logger->expects(self::once())
            ->method('critical');

        $this->expectException(\Exception::class);
        $this->adapter->call($request);
    }

    public function testClientExceptionWithResponse()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;

        $request = $this->createMock(RequestInterface::class);
        $clientResponse = $this->createMock(PsrResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $exception = $this->createMock(ClientException::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn(null);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willThrowException($exception);
        $exception->expects(self::once())
            ->method('getResponse')
            ->willReturn($clientResponse);
        $clientResponse->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(HttpCode::HTTP_CODE_NOT_FOUND);
        $this->logger->expects(self::once())
            ->method('warning');
        $this->responseFactory->expects(self::once())
            ->method('createError')
            ->with($clientResponse)
            ->willReturn($response);

        $result = $this->adapter->call($request);
        $this->assertEquals($response, $result);
    }

    public function testClientExceptionWithoutResponse()
    {
        $endpoint = uniqid();
        $uri = $this->urn . '/' . $endpoint;

        $request = $this->createMock(RequestInterface::class);
        $exception = $this->createMock(ClientException::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn(null);
        $request->expects(self::once())
            ->method('getMethod')
            ->willReturn(HttpMethod::METHOD_GET);
        $options = [
            RequestOptions::TIMEOUT => AdapterInterface::DEFAULT_TIMEOUT,
        ];
        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);
        $this->client->expects(self::once())
            ->method('request')
            ->with(HttpMethod::METHOD_GET, $uri, $options)
            ->willThrowException($exception);
        $exception->expects(self::once())
            ->method('getResponse')
            ->willReturn(null);
        $this->logger->expects(self::once())
            ->method('error');

        $this->expectException(ClientException::class);
        $this->adapter->call($request);
    }

    public function testDataRequestOptionInvalid()
    {
        $endpoint = uniqid();
        $data = uniqid();

        $request = $this->createMock(RequestInterface::class);

        $request->expects(self::once())
            ->method('getEndpoint')
            ->willReturn($endpoint);
        $request->expects(self::once())
            ->method('getData')
            ->willReturn($data);
        $request->expects(self::once())
            ->method('getDataRequestOption')
            ->willReturn(uniqid());

        $this->expectException(\InvalidArgumentException::class);
        $this->adapter->call($request);
    }
}
