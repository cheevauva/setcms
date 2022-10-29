<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Module\Module01\Mapper\Entity01EntityDbMapper;
use SetCMS\Module\Module01\Module01Constrants;

trait Entity01EntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): Entity01EntityDbMapper
    {
        return Entity01EntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return Module01Constrants::TABLE_NAME;
    }

}
