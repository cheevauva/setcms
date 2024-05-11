<?php

declare(strict_types=1);

namespace SetCMS\Core;

class CorePublicController extends CoreDynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\{module}PublicController';
    }

}
