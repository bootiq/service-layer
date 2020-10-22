<?php

namespace BootIqTest\ServiceLayer\Response;

use BootIq\ServiceLayer\Response\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseTest extends TestCase
{

    public function testAll()
    {
        $error = true;
        $httpCode = rand(100, 999);
        $responseData = uniqid();
        $psrResponse  = $this->createMock(ResponseInterface::class);

        $response = new Response(
            $error,
            $httpCode,
            $responseData,
            $psrResponse
        );
        $this->assertEquals($error, $response->isError());
        $this->assertEquals($httpCode, $response->getHttpCode());
        $this->assertEquals($responseData, $response->getResponseData());
        $this->assertEquals($psrResponse, $response->getPsrResponse());
    }
}
