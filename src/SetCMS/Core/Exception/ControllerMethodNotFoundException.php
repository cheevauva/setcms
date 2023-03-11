<?php

declare(strict_types=1);

namespace SetCMS\Controller\Exception;

class ControllerMethodNotFoundException extends ControllerNotFoundException
{

    public function __construct(protected string $controller, protected string $method)
    {
        
    }
    public function label(): string
    {
        return 'setcms.controller.method.notfound';
    }

    public function placeholders(): array
    {
        $params = parent::placeholders();
        $params['method'] = $this->method;

        return $params;
    }

}
