<?php

declare(strict_types=1);

namespace SetCMS\Application\Router;

class RouterMatchDTO extends \UUA\DTO
{

    /**
     * route name
     * @var string
     */
    public string $name;

    /**
     * @var array<(string|int)|mixed>
     */
    public array $params;

    /**
     * Controller::action
     * @var string
     */
    public string $target;
}
