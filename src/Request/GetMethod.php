<?php

namespace BootIq\ServiceLayer\Request;

use BootIq\ServiceLayer\Enum\HttpMethod as HttpMethodEnum;

abstract class GetMethod extends HttpMethod implements RequestInterface
{

    /**
     * @var bool
     */
    protected $cacheable = true;

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->cacheable;
    }

    /**
     * @param bool $cacheable
     */
    public function setCacheable(bool $cacheable)
    {
        $this->cacheable = $cacheable;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return HttpMethodEnum::METHOD_GET;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return null;
    }
}
