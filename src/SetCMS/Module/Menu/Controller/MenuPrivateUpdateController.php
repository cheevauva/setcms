<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Menu\DAO\MenuRetrieveByIdDAO;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;

#[RequestMethod('POST')]
class MenuPrivateUpdateController extends \SetCMS\Controller
{

    #[\Override]
    protected function units(): array
    {
        return [
            MenuRetrieveByIdDAO::class,
            MenuSaveDAO::class,
        ];
    }
}
