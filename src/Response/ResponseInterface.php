<?php

namespace BootIq\ServiceLayer\Response;

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
}
