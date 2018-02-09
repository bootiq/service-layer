<?php

namespace BootIqTest\ServiceLayer\Response;

use BootIq\ServiceLayer\Response\Response;
use BootIq\ServiceLayer\Response\ResponseFactory;
use BootIq\ServiceLayer\Response\ResponseInterface as CmsResponseInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseFactoryTest extends TestCase
{

    /**
     * @var ResponseFactory
     */
    private $factory;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        $this->factory = new ResponseFactory();
    }

    public function testErrorCreator()
    {
        $statusCode = rand(10, 999);
        $data = uniqid();

        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($statusCode);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($data);

        $result = $this->factory->createError($response);
        $this->assertInstanceOf(Response::class, $result);
        $this->assertInstanceOf(CmsResponseInterface::class, $result);
        $this->assertTrue($result->isError());
        $this->assertEquals($data, $result->getResponseData());
        $this->assertEquals($statusCode, $result->getHttpCode());
    }

    public function testSuccessCreator()
    {
        $statusCode = rand(10, 999);
        $data = uniqid();

        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($statusCode);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $stream->expects(self::once())
            ->method('getContents')
            ->willReturn($data);

        $result = $this->factory->createSuccess($response);
        $this->assertInstanceOf(Response::class, $result);
        $this->assertInstanceOf(CmsResponseInterface::class, $result);
        $this->assertFalse($result->isError());
        $this->assertEquals($data, $result->getResponseData());
        $this->assertEquals($statusCode, $result->getHttpCode());
    }
}
