<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Module\Menu\Mapper\MenuMapper;
use SetCMS\Module\Menu\MenuConstrants;

trait MenuGenericDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;
    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

    #[\Override]
    protected function mapper(): MenuMapper
    {
        return MenuMapper::make($this->factory());
    }

    #[\Override]
    protected function table(): string
    {
        return MenuConstrants::TABLE_NAME;
    }
}
