<?php

namespace BootIq\ServiceLayer\Response;

class Response implements ResponseInterface
{

    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var string
     */
    private $responseData;

    /**
     * Response constructor.
     * @param bool $error
     * @param int $httpCode
     * @param string $responseData
     */
    public function __construct(bool $error, int $httpCode, string $responseData)
    {
        $this->error = $error;
        $this->httpCode = $httpCode;
        $this->responseData = $responseData;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return string
     */
    public function getResponseData(): string
    {
        return $this->responseData;
    }
}
