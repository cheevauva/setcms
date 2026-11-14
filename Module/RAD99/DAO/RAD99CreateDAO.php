<?php

declare(strict_types=1);

namespace Module\RAD99\DAO;

use Module\RAD99\Mapper\RAD99ToRowMapper;

class RAD99CreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\RAD99\Traits\RAD99DbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return RAD99ToRowMapper::call($this, $this->entity)->row;
    }
}
