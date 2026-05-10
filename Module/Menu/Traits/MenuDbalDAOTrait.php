<?php

declare(strict_types=1);

namespace Module\Menu\Traits;

use Module\Menu\MenuConstrants;

trait MenuDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return MenuConstrants::TABLE_NAME;
    }
}
