<?php

declare(strict_types=1);

namespace SetCMS\Controller;

class ResourceController extends DynamicController
{
    use \SetCMS\Router\RouterTrait;
    
    protected function getSection(): string
    {
        return 'Resource';
    }

}
