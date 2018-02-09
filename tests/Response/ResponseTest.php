<?php

namespace BootIqTest\ServiceLayer\Response;

use BootIq\ServiceLayer\Response\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    public function testAll()
    {
        $error = true;
        $httpCode = rand(100, 999);
        $responseData = uniqid();

        $response = new Response(
            $error,
            $httpCode,
            $responseData
        );
        $this->assertEquals($error, $response->isError());
        $this->assertEquals($httpCode, $response->getHttpCode());
        $this->assertEquals($responseData, $response->getResponseData());
    }
}
