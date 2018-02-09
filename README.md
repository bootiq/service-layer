BootIq - Service Layer
========
![BOOT!Q Logo](http://www.bootiq.io/images/footer-logo.png "BOOT!Q")

[![pipeline status](https://gitlab.mb-e.sk/internal/service-layer/badges/master/pipeline.svg)](https://gitlab.mb-e.sk/internal/service-layer/commits/master) [![coverage report](https://gitlab.mb-e.sk/internal/service-layer/badges/master/coverage.svg)](https://gitlab.mb-e.sk/internal/service-layer/commits/master)

Service Layer vendor, for SOA communication (REST/SOAP).

## Installation

For installation of Boot!Q Service Layer, use composer: 

```bash
composer require bootiq/service-layer
```
## Adapters
### BootIq\ServiceLayer\Adapter\GuzzleAdapter

Default adapter is *GuzzleAdapter*, primary for REST communication.

#### Configuration

  * dependencies
    * client - *GuzzleHttp\ClientInterface* - client for calling requests.
    * responseFactory - *BootIq\ServiceLayer\Response\ResponseFactoryInterface* - response factory for creating specific response.
    * urn - URN of API (for example: https://api.bootiq.io).
  * timeout - request timeout provided by *setTimeout* method (default: 10s).
  * cache - if you want cache responses, provide your cache service (PSR-16).
  * logger - if you want log what is going on in adapter, provide your logger service (PSR-3).

### Own adapter

To create your own adapter, you have to implement *BootIq\ServiceLayer\Adapter\AdapterInterface*. 

## Enum

Library provides enums:
  * *BootIq\ServiceLayer\Enum\HttpCode* - List of all HTTP codes according to http://www.restapitutorial.com/httpstatuscodes.html.
  * *BootIq\ServiceLayer\Enum\HttpMethod* - List of all available HTTP methods according to http://www.restapitutorial.com/lessons/httpmethods.html.
  
## Exception

We provide base exception for working with our service layer (*BootIq\ServiceLayer\Exception\ServiceLayerException*).

## Requests

**Every request which can be called by adapter must implement *BootIq\ServiceLayer\Request\RequestInterface*.**

In *BootIq\ServiceLayer\Request* namespace are abstract classes for various http methods, for more simple integration with our service layer.

For example:
```php
<?php

namespace BootIq\CmsApiVendor\Request\Page;

use BootIq\ServiceLayer\Request\GetMethod;

class GetPageRequest extends GetMethod
{

    /**
     * @var int
     */
    private $pageId;

    /**
     * GetPageRequest constructor.
     * @param int $pageId
     */
    public function __construct(int $pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return 'page/' . $this->pageId;
    }
}
``` 

## Response

**Every response returned by adapter must implement *BootIq\ServiceLayer\Response\ResponseInterface*.**

We provide default response object *BootIq\ServiceLayer\Response\Response* and default response factory *BootIq\ServiceLayer\Response\ResponseFactory* for faster implementation.
