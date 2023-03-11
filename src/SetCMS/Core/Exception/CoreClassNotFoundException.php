<?php

declare(strict_types=1);

namespace SetCMS\Core\Exception;

use SetCMS\Contract\NotFound;

class CoreClassNotFoundException extends CoreException implements NotFound
{

    public function __construct(protected string $controller)
    {
        
    }

    public function label(): string
    {
        return 'setcms.class.notfound';
    }

    public function placeholders(): array
    {
        return [
            'controller' => $this->controller,
        ];
    }

}
