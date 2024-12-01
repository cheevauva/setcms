<?php

declare(strict_types=1);

namespace SetCMS\Core\Controller;

class CorePublicController extends CoreDynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}PublicController';
    }

}
