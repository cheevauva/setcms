<?php

declare(strict_types=1);

namespace SetCMS\Controller\Exception;

use SetCMS\Contract\NotFound;

class ControllerNotFoundException extends ControllerException implements NotFound
{

    public function __construct(protected string $controller)
    {
        
    }

    public function label(): string
    {
        return 'setcms.controller.notfound';
    }

    public function placeholders(): array
    {
        return [
            'controller' => $this->controller,
        ];
    }

}
