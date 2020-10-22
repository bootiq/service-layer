<?php

namespace BootIq\ServiceLayer\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseInterface
{

    /**
     * @return bool
     */
    public function isError(): bool;

    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @return string
     */
    public function getResponseData(): string;

    /**
     * @return PsrResponseInterface
     */
    public function getPsrResponse(): PsrResponseInterface;
}
