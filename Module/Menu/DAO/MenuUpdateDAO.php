<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Mapper\MenuToRowMapper;

class MenuUpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\Menu\Traits\MenuCallTrait;
    use \Module\Menu\Traits\MenuDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return MenuToRowMapper::call($this->container, $this->menu)->row;
    }
}
