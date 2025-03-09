<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('GET')]
class MenuPrivateNewController extends MenuPrivateEditController
{

    #[\Override]
    protected function units(): array
    {
        return [];
    }
}
