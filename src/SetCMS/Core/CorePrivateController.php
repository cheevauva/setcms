<?php

declare(strict_types=1);

namespace SetCMS\Core;

class CorePrivateController extends CoreDynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\{module}PrivateController';
    }

}
