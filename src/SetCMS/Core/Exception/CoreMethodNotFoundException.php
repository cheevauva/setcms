<?php

declare(strict_types=1);

namespace SetCMS\Core\Exception;

class CoreMethodNotFoundException extends CoreClassNotFoundException
{

    public function __construct(protected string $controller, protected string $method)
    {
        
    }

    public function label(): string
    {
        return 'setcms.class.method.notfound';
    }

    public function placeholders(): array
    {
        $params = parent::placeholders();
        $params['method'] = $this->method;

        return $params;
    }

}
