<?php

declare(strict_types=1);

namespace Module\Module99\DAO;

use Module\Module99\Mapper\Entity99ToRowMapper;

class Entity99UpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityUpdateTrait;
    use \Module\Module99\Traits\Entity99CallTrait;
    use \Module\Module99\Traits\Entity99DbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return Entity99ToRowMapper::call($this->container, $this->entity99)->row;
    }
}
