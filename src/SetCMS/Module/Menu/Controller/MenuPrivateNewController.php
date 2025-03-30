<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

class MenuPrivateNewController extends MenuPrivateEditController
{

    #[\Override]
    protected function domainUnits(): array
    {
        return [];
    }
}
