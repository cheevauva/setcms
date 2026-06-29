<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Mapper\MenuToRowMapper;

class MenuCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Menu\Traits\MenuCallTrait;
    use \Module\Menu\Traits\MenuDbalDAOTrait;

    protected function row(): array
    {
        return MenuToRowMapper::call($this->container, $this->menu)->row;
    }
}
