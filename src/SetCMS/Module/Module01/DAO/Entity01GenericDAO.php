<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Module\Module01\Mapper\Entity01Mapper;
use SetCMS\Module\Module01\Module01Constrants;

trait Entity01GenericDAO
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): Entity01Mapper
    {
        return Entity01Mapper::make($this->factory());
    }

    protected function table(): string
    {
        return Module01Constrants::TABLE_NAME;
    }

}
