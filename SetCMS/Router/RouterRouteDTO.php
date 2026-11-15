<?php

declare(strict_types=1);

namespace SetCMS\Router;

use Psr\Http\Message\ServerRequestInterface;

class RouterRouteDTO extends \UUA\DTO
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
    
    public static function fromRequest(ServerRequestInterface $request, string $name = 'route'): static 
    {
        return static::as($request->getAttribute($name));
    }
}
