<?php

declare(strict_types=1);

namespace SetCMS\Router;

class RouterMatchDTO
{

    /**
     * route name
     * @var string
     */
    public string $name;
    public array $params;

    /**
     * Controller::action
     * @var string
     */
    public string $target;

}
