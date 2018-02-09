<?php

namespace BootIq\ServiceLayer\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseFactoryInterface
{

    /**
     * @param PsrResponseInterface $response
     * @return ResponseInterface
     */
    public function createError(PsrResponseInterface $response): ResponseInterface;

    /**
     * @param PsrResponseInterface $response
     * @return ResponseInterface
     */
    public function createSuccess(PsrResponseInterface $response): ResponseInterface;
}
