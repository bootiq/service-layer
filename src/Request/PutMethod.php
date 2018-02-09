<?php

namespace BootIq\ServiceLayer\Request;

use BootIq\ServiceLayer\Enum\HttpMethod as HttpMethodEnum;

abstract class PutMethod extends HttpMethod implements RequestInterface
{

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
        return HttpMethodEnum::METHOD_PUT;
    }
}
