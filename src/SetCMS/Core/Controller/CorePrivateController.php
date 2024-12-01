<?php

declare(strict_types=1);

namespace SetCMS\Core\Controller;

class CorePrivateController extends CoreDynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}PrivateController';
    }

}
