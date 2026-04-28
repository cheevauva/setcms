<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\Mapper\Entity01ToRowMapper;

class Entity01CreateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityCreateTrait;
    use \Module\Module01\Traits\Entity01CallTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return Entity01ToRowMapper::call($this->container, $this->entity01)->row;
    }
}
