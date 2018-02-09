<?php

namespace BootIq\ServiceLayer\Request;

use BootIq\ServiceLayer\Enum\HttpMethod as HttpMethodEnum;

abstract class HeadMethod extends HttpMethod implements RequestInterface
{

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return HttpMethodEnum::METHOD_HEAD;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return null;
    }
}
