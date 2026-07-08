<?php

declare(strict_types=1);

namespace Module\RAD01\DAO;

use Module\RAD01\Mapper\RAD01ToRowMapper;

class RAD01CreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\RAD01\Traits\RAD01CallTrait;
    use \Module\RAD01\Traits\RAD01DbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return RAD01ToRowMapper::call($this->container, $this->rad01)->row;
    }
}
