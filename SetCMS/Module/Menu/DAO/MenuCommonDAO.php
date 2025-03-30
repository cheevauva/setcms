<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Module\Menu\Mapper\MenuMapper;
use SetCMS\Module\Menu\MenuConstrants;

trait MenuCommonDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    #[\Override]
    protected function mapper(): MenuMapper
    {
        return MenuMapper::new($this->container);
    }

    #[\Override]
    protected function table(): string
    {
        return MenuConstrants::TABLE_NAME;
    }
}
