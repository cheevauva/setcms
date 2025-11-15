<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Mapper\MenuMapper;
use Module\Menu\MenuConstrants;

trait MenuCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

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
