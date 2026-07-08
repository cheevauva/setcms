<?php

declare(strict_types=1);

namespace Module\RAD99\DAO;

use Module\RAD99\Mapper\RAD99ToRowMapper;

class RAD99UpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\RAD99\Traits\RAD99CallTrait;
    use \Module\RAD99\Traits\RAD99DbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return RAD99ToRowMapper::call($this->container, $this->rad99)->row;
    }
}
