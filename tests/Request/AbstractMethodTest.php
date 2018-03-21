<?php

namespace BootIqTest\ServiceLayer\Request;

use BootIq\ServiceLayer\Enum\HttpMethod;
use BootIq\ServiceLayer\Request\DeleteMethod;
use BootIq\ServiceLayer\Request\GetMethod;
use BootIq\ServiceLayer\Request\HeadMethod;
use BootIq\ServiceLayer\Request\HttpMethod as HttpMethodRequest;
use BootIq\ServiceLayer\Request\PostMethod;
use BootIq\ServiceLayer\Request\PutMethod;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AbstractMethodTest extends TestCase
{

    public function testHttpMethod()
    {
        $class = new class extends HttpMethodRequest
        {

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }

            /**
             * @return bool
             */
            public function isCacheable(): bool
            {
                return false;
            }

            /**
             * @return string
             */
            public function getMethod(): string
            {
                return HttpMethod::METHOD_DELETE;
            }

            /**
             * @return array|null
             */
            public function getData()
            {
                return null;
            }
        };

        $this->assertEquals(HttpMethod::METHOD_DELETE, $class->getMethod());
        $this->assertEmpty($class->getData());
        $this->assertFalse($class->isCacheable());
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getEndpoint());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }

    public function testGetMethod()
    {
        $class = new class extends GetMethod {

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }
        };

        $this->assertEquals(HttpMethod::METHOD_GET, $class->getMethod());
        $this->assertEmpty($class->getData());
        $this->assertTrue($class->isCacheable());
        $class->setCacheable(false);
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getEndpoint());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }

    public function testHeadMethod()
    {
        $class = new class extends HeadMethod {

            /**
             * @return bool
             */
            public function isCacheable(): bool
            {
                return false;
            }

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }
        };

        $this->assertEquals(HttpMethod::METHOD_HEAD, $class->getMethod());
        $this->assertEmpty($class->getData());
        $this->assertEmpty($class->getEndpoint());
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }

    public function testPostMethod()
    {
        $class = new class extends PostMethod {

            /**
             * @return bool
             */
            public function isCacheable(): bool
            {
                return false;
            }

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }

            /**
             * @return array|null
             */
            public function getData()
            {
                return null;
            }
        };

        $this->assertEquals(HttpMethod::METHOD_POST, $class->getMethod());
        $this->assertEmpty($class->getEndpoint());
        $this->assertEmpty($class->getData());
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }

    public function testPutMethod()
    {
        $class = new class extends PutMethod {

            /**
             * @return bool
             */
            public function isCacheable(): bool
            {
                return false;
            }

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }

            /**
             * @return array|null
             */
            public function getData()
            {
                return null;
            }
        };

        $this->assertEquals(HttpMethod::METHOD_PUT, $class->getMethod());
        $this->assertEmpty($class->getEndpoint());
        $this->assertEmpty($class->getData());
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }

    public function testDeleteMethod()
    {
        $class = new class extends DeleteMethod {

            /**
             * @return bool
             */
            public function isCacheable(): bool
            {
                return false;
            }

            /**
             * @return string
             */
            public function getEndpoint(): string
            {
                return '';
            }

            /**
             * @return array|null
             */
            public function getData()
            {
                return null;
            }
        };

        $this->assertEquals(HttpMethod::METHOD_DELETE, $class->getMethod());
        $this->assertEmpty($class->getEndpoint());
        $this->assertEmpty($class->getData());
        $this->assertFalse($class->isCacheable());
        $this->assertEmpty($class->getHeaders());
        $key = uniqid();
        $value = uniqid();
        $class->addHeader($key, $value);
        $this->assertEquals($value, $class->getHeader($key));
        $class->setHeaders([$key => $value]);
        $this->assertEquals($value, $class->getHeader($key));
        $this->assertEquals([$key => $value], $class->getHeaders());
        $this->assertEquals(RequestOptions::JSON, $class->getDataRequestOption());
    }
}