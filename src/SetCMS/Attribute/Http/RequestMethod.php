<?php

declare(strict_types=1);

namespace SetCMS\Attribute\Http;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class RequestMethod
{

    public string $method;

    public function __construct(string $method)
    {
        $this->method = $method;
    }
}
