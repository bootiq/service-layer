<?php

namespace BootIq\ServiceLayer\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

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
     * @var PsrResponseInterface
     */
    private $psrResponse;

    /**
     * Response constructor.
     * @param bool $error
     * @param int $httpCode
     * @param string $responseData
     * @param PsrResponseInterface $psrResponse
     */
    public function __construct(bool $error, int $httpCode, string $responseData, PsrResponseInterface $psrResponse)
    {
        $this->error = $error;
        $this->httpCode = $httpCode;
        $this->responseData = $responseData;
        $this->psrResponse = $psrResponse;
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

    /**
     * @return PsrResponseInterface
     */
    public function getPsrResponse(): PsrResponseInterface
    {
        return $this->psrResponse;
    }
}
