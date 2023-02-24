<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\DAO;

use SetCMS\Module\Session\Mapper\SessionMapper;
use SetCMS\Module\Session\SessionConstrants;

trait SessionGenericDAO
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): SessionMapper
    {
        return SessionMapper::make($this->factory());
    }

    protected function table(): string
    {
        return SessionConstrants::TABLE_NAME;
    }

}
