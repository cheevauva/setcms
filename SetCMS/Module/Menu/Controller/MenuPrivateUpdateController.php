<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;

class MenuPrivateUpdateController extends \SetCMS\ControllerViaPSR7
{

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyByCriteriaDAO::class,
            MenuSaveDAO::class,
        ];
    }
}
