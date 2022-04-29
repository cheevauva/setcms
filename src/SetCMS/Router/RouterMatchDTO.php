<?php

declare(strict_types=1);

namespace SetCMS\Router;

class RouterMatchDTO
{
    public string $name;
    public array $target;
    public array $params;
}
