<?php

namespace BootIq\ServiceLayer\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseFactory implements ResponseFactoryInterface
{

    /**
     * @param PsrResponseInterface $response
     * @return ResponseInterface
     */
    public function createError(PsrResponseInterface $response): ResponseInterface
    {
        return new Response(
            true,
            $response->getStatusCode(),
            $response->getBody()->getContents(),
            $response
        );
    }

    /**
     * @param PsrResponseInterface $response
     * @return ResponseInterface
     */
    public function createSuccess(PsrResponseInterface $response): ResponseInterface
    {
        return new Response(
            false,
            $response->getStatusCode(),
            $response->getBody()->getContents(),
            $response
        );
    }
}
